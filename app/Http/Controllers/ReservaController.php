<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Reserva;
use App\ReservaActividad;
use App\Fun;
use Carbon\Carbon;
use Yajra\Datatables\Datatables;

class ReservaController extends Controller {

    public function getData() {

        $reservas = Reserva::select()->where('collection_status','!=','')->orderBy('id', 'desc');

        //$reservas = Reserva::select()->orderBy('id', 'desc');
        
        return Datatables::of($reservas)
    
            ->addColumn('id', function ($reserva) {
                return "<a href='edit-reserva/$reserva->id'>$reserva->id</a>"; 
            })

            ->addColumn('fechaReg', function ($reserva) {
                return '<spam style="font-size:11px">'.Carbon::parse($reserva->fechaReg)->format('d-m-Y H:i').'hs'.'</spam>';
            })

            ->addColumn('titular', function ($reserva) {
                return Str::limit($reserva->titular, 20); 
            })

            ->addColumn('fecha', function ($reserva) {
                return $reserva->fecha; 
            })

            ->addColumn('total_raw', function ($reserva) {
                return '$'.number_format($reserva->total ,0, ',', '.'); 
            })

            ->addColumn('estado', function ($reserva) {
                return Fun::getIconStatus($reserva->estado); 
            })

            ->addColumn('collection_status', function ($reserva) {
                return Reserva::getPagoStatus($reserva->id, $reserva->tipoPago); 
            })

            ->addColumn('pago', function ($reserva) {
                return $reserva->tipoPago === 1 ? " 
                <img src='".asset('images/mercado-pago-logo.png')."' class='logo-tipopago' > " : " 
                <img src='".asset('images/coinbase-logo.png')."' class='logo-tipopago' >  "; 
            })

            ->addColumn('acciones', function ($reserva) {
                return "<a href='delete-reserva/$reserva->id' class='delReg'><i class='fa fa-trash-o' aria-hidden='true'></i></a>";
            })

            ->rawColumns(['id','entradas','fechaReg','estado','acciones','tipo','pago','collection_status'])    
            ->make(true);

    }

    /*********************************************************/
    /*                      V I E W                          */
    /*********************************************************/    

    public function viewReservas() {

        $reservas = Reserva::orderBy('id','asc')->get();
        return view('admin.reservas.view_reservas')->with(compact('reservas'));
    }

    /*********************************************************/
    /*                      E D I T                          */
    /*********************************************************/

    public function editReserva(Request $request, $id = null) {

        if ($request->isMethod('post')) {

            $data = $request->all();
            
            Reserva::where(['id'=>$id])->update([
                'comentarios' => $data['comentarios'],
                'estado' => $data['estado'],
                ]);

            return redirect('/admin/view-reservas')->with('flash_message','Reserva actualizada correctamente...');
        
        }

        $actividades = ReservaActividad::where('idReserva','=',$id)->get();
        $reserva = Reserva::where(['id'=>$id])->first();
       
        return view('admin.reservas.edit_reserva')->with(compact('reserva', 'actividades'));
    
    }


    /*********************************************************/
    /*                   D E L E T E                       */
    /*********************************************************/

    public function deleteReserva(Request $request, $id = null) {

        if (!empty($id)) {
            Reserva::where(['id'=>$id])->delete();
            return redirect('/admin/view-reservas')->with('flash_message','Reserva eliminada...');
        }

        $reservas = Reserva::get();
        return view('admin.reservas.view_reservas')->with(compact('reservas'));
    
    }

    public function actionReceive_ipn() {

        Yii::import('ext.Mp/lib.mercadopago', true);
        $mp = new MP(Yii::app()->params['client_id'], Yii::app()->params['client_secret']);
        //$mp = new MP(Yii::app()->params['client_id_test'], Yii::app()->params['client_secret_test']);
        $params = ["access_token" => $mp->get_access_token()];

        // Check mandatory parameters
        if (!isset($_GET["id"], $_GET["topic"]) || !ctype_digit($_GET["id"])) {
            http_response_code(400);
            return;
        }

        if($_GET["topic"] == 'payment') {

            $payment_info = $mp->get("/collections/notifications/" . $_GET["id"], $params, false);

            $merchant_order_info = $mp->get("/merchant_orders/" . $payment_info["response"]["collection"]["merchant_order_id"], $params, false);

            //echo $body = $_GET["topic"].' / '.$_GET["id"].' / '.$payment_info["response"]["collection"]["external_reference"];

            $reserva = Reservasd::model()->findByPK($payment_info["response"]["collection"]["external_reference"]);

    if ($reserva->estado == 0) { //si viene la primera vez, en 0, actualizo estado a 1 y mando email
            
        $reserva->collection_id = $payment_info["response"]["collection"]["id"];
        $reserva->collection_status = $payment_info["response"]["collection"]["status"];
        $reserva->payment_type = $payment_info["response"]["collection"]["payment_type"];
        $reserva->merchant_order_id = $payment_info["response"]["collection"]["merchant_order_id"];
        $reserva->external_reference = $payment_info["response"]["collection"]["external_reference"];
        
        /* actualizo campo estado para no enviar el email nuevamente */
        $reserva->estado = 1;       
        //$reserva->estado = 0;     

        $reserva->update();

    /* ARMO EMAIL */

    $config = Config::model()->findByPK(1);

    $pais = Paises::model()->findByPK($reserva->idPais);
    $provincia = Provincias::model()->findByPK($reserva->idProvincia);

    /* forma de pago */

    $fpago = ($reserva->fpago == 'mp') ? 'Mercado Pago' : 'PayPal';

    /* TOTALES  */

    $totales = "
        <p>Total: <b>$ ".number_format($reserva->precio,2, ',', '.')."</b></p> 
        <p>Descuento: <b>$ ".number_format($reserva->descuento,2, ',', '.')."</b></p> 
        <p><b>TOTAL A PAGAR: $ ".number_format($reserva->total,2, ',', '.')."</b></p>";

    /* ACTIVIDADES  */

    $actividades = getActividadesPaqueteGracias($reserva->idReserva); // elif x 2

    $body = "

    <p>Gracias por elegirnos, a continuación, le enviamos los datos de su reserva.<br>
    Recuerde guardar este email, para presentarlo el día de la actividad.</p>
    
    <h3>N° de Reserva : <strong>".$payment_info["response"]["collection"]["id"]."</strong></h3>
    <hr>

    <p><b>Detalle de actividades</b></p>

    ".$actividades."

    <hr>

    ".$totales."    

    <hr>

    <b>Fecha de la Actividad : </b>".date('d/m/Y', $reserva->fecha)."<br> 
    <b>Nombre : </b>".$reserva->titular."<br> 
    <b>Email : </b>".$reserva->email."<br> 
    <b>Teléfono : </b>".$reserva->telefono."<br> 
    <b>Pais: </b>".$pais['nombre']."<br>
    <b>Provincia : </b>".$provincia['nombre']."<br> 
    <b>Comentarios : </b>".$reserva->comentarios."<br>
    <b>Forma de pago: </b>".$fpago." 

    <hr>

<li>Hacemos factura B o A.</li>
<li>En caso de cancelación, por parte del pasajero, de la actividad tendrá un
reembolso del 70% del total abonado, en caso de cancelación, por parte de la
empresa, de actividad por razones ajenas a la empresa, cómo el estado del tiempo
o la falta de agua en el río, etc. ,tendrá un reembolso del 100% de lo abonado.</li>
<li>En caso de no presentarse a la actividad el día de la reserva no obtendrá
reembolso.</li>
<li>Puede reprogramar la actividad hasta 24 horas antes sin cargo.</li>
<li>Recuerde que para poder hacer las actividades deberá contar con tapaboca o
barbijo, protección ocular y en caso de ser necesario guantes moteados para
actividades como rappel y tirolesa.</li></br>
<p>En breve nos pondremos en contacto para coordinar horarios y lugar de la actividad, si no
lo hacemos, por favor envíanos un whatsapp al 2604057755 indicando el número de
reserva.</p>
    ";

            $mail = new YiiMailer();
            $mail->setView('contact');
            $mail->setData(array('message' => '', 'name' => '',
                 'description' => $body));

            $mail->setFrom('info@xxxx.com', 'xxx xx');

            $mail->AddAddress($reserva->email);

            $archivo = 'consentimiento.pdf';
            $mail->AddAttachment($archivo,$archivo);

            $contactos = explode(";",$config->contacto);
             foreach ($contactos as $contacto) {
                $mail->AddAddress($contacto);
             }           
                
                $mail->setSubject('Reserva xx xx');

                $mail->smtpConnect([
                    'ssl' => [
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    ]
                ]);

                //send
                if ($mail->send()) {
                    Yii::app()->user->setFlash('contact','Gracias...');
                    
                } else {
                    echo $mail->getError();
                    Yii::app()->user->setFlash('error','Error : '.$mail->getError());
                }

        /* FIN EMAIL RESERVA */
        } //endif de if ($reserva->estado==0)   

        
            } else if ($_GET["topic"] == 'merchant_order') {

                $merchant_order_info = $mp->get("/merchant_orders/" . $_GET["id"], $params, false);

            }

        }

}
