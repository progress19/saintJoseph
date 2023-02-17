<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

use App\Config;
use App\Actividad;
use App\Reserva;
use App\ReservaActividad;
use App\ImgsHome;
use Session;

use DB;

use \MercadoPago\Item;
use \MercadoPago\MerchantOrder;
use \MercadoPago\Payer;
use \MercadoPago\Payment;
use \MercadoPago\Preference;
use \MercadoPago\SDK;

use CoinbaseCommerce\ApiClient;
use CoinbaseCommerce\Resources\Checkout;
use CoinbaseCommerce\Resources\Charge;

class Controller extends BaseController {
    
  use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


  public function viewHome() { 
  
    //$destacadas = Actividad::where('estado',1)->where('tipo',2)->orderBy('orden','asc')->get();
    $actividades = Actividad::where('estado',1)->orderBy('orden','asc')->get();

    $imgsHome = ImgsHome::where('estado','=',1)->inRandomOrder()->limit(16)->get();

    return view('home')->with([
      'actividades' => $actividades,
      'imgsHome' => $imgsHome,
      //'destacadas' => $destacadas,
      'tipo' => 1
    ]);

  }
  
  public function viewOffline() { return view('offline'); }

  public function getChargeUpdate() {

   $reserva = Reserva::where('preference_id', '=', $_REQUEST['checkoutId'])->first();

   if ($reserva) {

      if ($reserva->codeCoinbase !='') {

         ApiClient::init("9e598e8f-ae8b-4f49-b3fc-409d56843666");

         $chargeObj = Charge::retrieve($reserva->codeCoinbase);

         //echo $reserva->codeCoinbase;

         //print_r($chargeObj);

         if ( count($chargeObj['payments']) > 0) {

            $status = $chargeObj['payments']['0']['status'];
         } else {
            //echo $chargeObj['payments'];
            $status = 'CREATED';

            //print_r($chargeObj['payments']);
         }
      } else {
         $status = 'WAITING';
      }
      return array( 'status' => $status, 'code' => $reserva->codeCoinbase );
   }
   
}


    public function testEmail(Request $request) {

      $config = Config::where(['id'=>1])->first();

      $data = []; 

      //se envia el array y la vista lo recibe en llaves individuales {{ $email }} , {{ $subject }}...
      \Mail::send('emails.test', $data, function($message) use ($config) {
      
          //remitente
          $message->from('noreply@xxxxxxxx.com', 'xxxxxxxx.com');
          
          //asunto
          $message->subject('TEST xxxxxxxx xxxxxxxx');
      
          //destinatarios
          $destinatarios = explode(',', $config->destinatarios);
          foreach ($destinatarios as $destinatario) {
              $message->to($destinatario, 'xxxxxxxx.com');  
          }
        
      });
    }
   
  public function enviarReserva(Request $request) {

    sleep(0); $cantEntradas = 0;

    if(isset($_POST['email']))  {

      foreach(session()->get('cart') as &$value) {
        $cantEntradas = $cantEntradas + $value['cantidad']; // para verificar cupo
      }
    
      $carro = session()->get('cart');
      $precio = 0;
      $descuento = 0;
      $total = 0;

      $reserva_save = session()->get('reserva_save');

      if ($reserva_save == 0) {  //consulto si ya grabe la reserva en backend

          //  grabo reserva por primera vez

          $model = new Reserva;
              
          $model->fecha = $request->fecha;
          $model->titular = $request->nombre;
          $model->email = $request->email;
          $model->telefono = $request->telefono;
          $model->comentarios = $request->comentario;
          $model->entradas = $cantEntradas;
          $model->precio = session()->get('total_sin_desc');
          $model->descuento = session()->get('total_descuento'); 
          $model->total = session()->get('total_a_pagar'); 
          $model->estado = 0;
          //$model->tipo = 1;
          $model->fechaReg = date('Y-m-d H:i:s');
                    
          if ($request->opcionPago == 1) {  // 1 - MP  / 2 - Coinbase
            $model->preference_id = session()->get('pref_id'); 
            $model->tipoPago = 1;
          }

          if ($request->opcionPago == 2) { 
            $model->preference_id = $request->checkoutId;
            $model->tipoPago = 2;
          }

          $model->external_reference = $request->external_reference; 

          if ($model->fecha) {

            $model->save();
            session()->put('reserva_save', 1);
            session()->put('idReserva', $model->id);
              
            foreach ( $carro as $actividad ) {

              $total = $total + $actividad['precio']*$actividad['cantidad'];
              
              $model_ra = new ReservaActividad;
                  
              $model_ra->idReserva = $model->id;
              $model_ra->idActividad = $actividad['id'];
              $model_ra->nombre = $actividad['nombre'];
              $model_ra->cantidad = $actividad['cantidad'];
              $model_ra->precio = $actividad['precio'];
              $model_ra->precio_tipo = $actividad['precio_tipo'];
              $model_ra->descuento = 0;
              $model_ra->total = $actividad['precio']*$actividad['cantidad'];
              //$model_ra->tipo = 1;
              //$model->estado = 1;

              $model_ra->save();
            }   
          }
      }
      
      if ($reserva_save == 1) {  //consulto si ya grabe la reserva en backend

          //actualizo reserva  

          if ($request->opcionPago == 1 ) {  // 1 - MP  / 2 - Coinbase
            $preference_id = session()->get('pref_id'); 
            $tipoPago = 1;
          }

          if ($request->opcionPago == 2 ) { 
            $preference_id = $request->checkoutId;
            $tipoPago = 2;
          }

        Reserva::where( ['external_reference' => $request->external_reference ] )->update([
            
            'fecha' => $request->fecha, 
            'titular' => $request->nombre, 
            'email' => $request->email, 
            'telefono' => $request->telefono,
            'comentarios' => $request->comentario, 
            'fechaReg' => date('Y-m-d H:i:s'), 
            'preference_id' => $preference_id, 
            'tipoPago' => $tipoPago,
        ]);

      } 

      return true;
          
    }  

  }


  public function checkDescuento() {
    
    $array = session()->get('cart');
    $cant = 0;

    foreach ($array as &$value) {
            $cant = $cant + $value['cantidad'];
        };
   
    if ($cant > 300) {
      return $cant*100; //$100
    } else {
      return 0; 
    }

    //return $cant;

  }

  public function cambiarCantidadAjax() { //cambio cantidad en array session 

    $array = session()->get('cart');

    //dd($array);

    foreach ( $array as $key => &$value ) {
  
      if ( $key == $_REQUEST['id'] ) { //busco id
  
          $value['cantidad'] = $_REQUEST['cant'];
      
          break; 
      };

    }

    session()->put('cart', $array); 
    session()->save();
    echo $_REQUEST['cant'] * $value['precio'];

 } 


   public function borrarActividadAjax() {

    echo 'id:'.$_REQUEST['id'];

      $array = session()->get('cart');
      unset($array[$_REQUEST['id']]);
      session()->put('cart', $array); 
      session()->save();

   }

   public function checkCarro() {
   
    if (session()->has('cart')) {
 
      $carro = session()->get('cart');
      $i = 1;+
      $dto = 0;

      //print_r($carro);

      foreach ( $carro as $actividad ) {

        switch ($actividad['precio_tipo']) {
          case '1': //adulto
            $precio_tipo = 'Adultos';
            break;
          case '2': //menor
            $precio_tipo = 'Menores';
            break;
        }

        echo '<li class="cd-cart__product">

            <div class="cd-cart__details">
              <h3 class="truncate">
                 #'.$i.' - '. $actividad["nombre"] .' 
              </h3>';
            
            echo '<span class="cd-cart__price">$'. $actividad["precio"] .'</span>';
                                                    
            echo '<span class="cd-cart__price__total" id="total_actividad'. $actividad["id"] . $actividad["precio_tipo"]. '" >$'. $actividad["precio"]*$actividad["cantidad"] .' </span>
              
              <div class="cd-cart__actions">
                
                <a href="#0" class="cd-cart__delete-item" onclick="borrarActividad('.$actividad["id"].$actividad["precio_tipo"].','.$actividad["precio_tipo"].')"> 
                  <i class="fa fa-times-circle" aria-hidden="true"></i>
                </a>       

                <div class="cd-cart__quantity">

                <label for="cd-product-'. $actividad["id"] .'">'.$precio_tipo.'</label>
                
                  <span class="cd-cart__select">
                    
                  <select class="reset" id="cd-product-'. $actividad["id"] .'" onchange="cambiarCantidad('.$actividad["id"].$actividad["precio_tipo"].',this.value)" name="quantity">
                  
                      <option value="1" '. ($actividad["cantidad"]==1 ? ' selected="selected"' : '') .' >1</option>
                      <option value="2" '. ($actividad["cantidad"]==2 ? ' selected="selected"' : '') .' >2</option>
                      <option value="3" '. ($actividad["cantidad"]==3 ? ' selected="selected"' : '') .' >3</option>
                      <option value="4" '. ($actividad["cantidad"]==4 ? ' selected="selected"' : '') .' >4</option>
                      <option value="5" '. ($actividad["cantidad"]==5 ? ' selected="selected"' : '') .' >5</option>
                      <option value="6" '. ($actividad["cantidad"]==6 ? ' selected="selected"' : '') .'>6</option>
                      <option value="7" '. ($actividad["cantidad"]==7 ? ' selected="selected"' : '') .'>7</option>
                      <option value="8" '. ($actividad["cantidad"]==8 ? ' selected="selected"' : '') .'>8</option>
                      <option value="9" '. ($actividad["cantidad"]==9 ? ' selected="selected"' : '') .'>9</option>
                      <option value="10" '. ($actividad["cantidad"]==10 ? ' selected="selected"' : '') .'>10</option>
                      <option value="11" '. ($actividad["cantidad"]==11 ? ' selected="selected"' : '') .'>11</option>
                      <option value="12" '. ($actividad["cantidad"]==12 ? ' selected="selected"' : '') .'>12</option>

                    </select>
                    
                  </span>
                </div>
              </div>
            <div class="linea-div-cart"></div>
            </div>
          </li>';

          $i++;}    

    }

 
   }

  public function getTotalConDescuento() { //calculo total a pagar

    $total_descuento = 0;
    $total_a_pagar = 0;
    $total_sin_desc = 0;
    $precio = 0;

    //print_r($_SESSION["cart"]);
    //dd(session()->get('cart'));
    
    if (session()->has('cart')) {

      foreach(session()->get('cart') as &$value) {
        $precio = $value['precio'] * $value['cantidad'];
        $total_sin_desc = $total_sin_desc + $precio;
      }
/*      
      if (session()->has('discount')) {
        $total_descuento = session()->get('discount');
      }      
*/
      $total_a_pagar = $total_sin_desc - $total_descuento;

      // envio total descuento // total con descuento
      echo $total_sin_desc.','. $total_descuento.','. $total_a_pagar;

    } 
    
 }

  public function searchCodeDisc() {
    
    $code = Codigo::where( 'code' , '=' ,$_REQUEST['code'] )
                ->whereDate('desde', '<=', now()->toDateString())
                ->whereDate('hasta', '>=', now()->toDateString())->first();
    
        if ( $code ) {
          session()->put('discount', $code->valor); 
          return 1;
        } else {
          session()->put('discount', 0); 
          return 0;
        }
  }

  public function checkDiscount() {

    if ( session()->get('discount') > 0) {
        return 1;
      } else {
        return 0;
      }
   }


  public function addActividadCarro($cant=1) {
    
    $actividad = Actividad::find($_REQUEST['id']);

    //$i = $_REQUEST['id'];

    $array = session()->get('cart');


    switch ($_REQUEST['precio']) {
      case '1': //adulto
        $precio = $actividad->precio_a;
        $precio_tipo = 'Adultos';
        break;
      case '2': //menor
        $precio = $actividad->precio_b;
        $precio_tipo = 'Menores';
        break;
    }    

    $key = $_REQUEST['id'].$_REQUEST['precio'];

    $array = \Arr::add($array, $key, array(
      'id' => $actividad->id,
      'nombre' => $actividad->nombre,
      'cantidad' => 1,
      'precio' => $precio,
      'precio_tipo' => $_REQUEST['precio'],
      )
    );
    
    //dd($array);
    //print_r($array);

  session()->put('cart', $array); 
  
  $count = count($array);

  //$dto = Controller::checkDescuento(count(session()->get('cart'))); //envio cantidad de elementos array

    echo '
    <li class="cd-cart__product">
      
      <div class="cd-cart__details">
        <h3 class="truncate">
          #'.$count.' - '. $actividad->nombre .' 
        </h3>';
      
        echo '<span class="cd-cart__price">$ '. $precio .' </span>';
        
        echo '<span class="cd-cart__price__total" id="total_actividad'. $actividad->id . $_REQUEST['precio'] .'" >$'. $precio .' </span>';

        echo '

        <div class="cd-cart__actions">
          
          <a href="#0" class="cd-cart__delete-item" onclick="borrarActividad('.$actividad->id.$_REQUEST['precio'].','.$_REQUEST['precio'].')"> 
            <i class="fa fa-times-circle" aria-hidden="true"></i>
          </a>       

          <div class="cd-cart__quantity">
          <label for="cd-product-'. $actividad->idActividad .'">'.$precio_tipo.'</label>
          <span class="cd-cart__select">
                            
              <select class="reset" id="cd-product-'. $actividad->id .'" onchange="cambiarCantidad('.$actividad->id.$_REQUEST['precio'].',this.value)" name="quantity">

                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
              </select>
          
            </span>
          </div>
        </div>
        <div class="linea-div-cart"></div>
      </div>
    </li>';

  }


  public function checkCantidad() {

      //session_start();
      $cant = 0;

      if (session()->has('cart')) {

          foreach(session()->get('cart') as &$value){
            $cant = $cant + $value['cantidad'];
          }
                      
      }

      echo json_encode($cant); 

   } 


   public function enviarContacto(Request $request) {
    
    sleep(1);

       //guarda el valor de los campos enviados desde el form en un array
       $data = $request->all();
        /*       
          $data = [
           'data' => $request->all(),
           'promo' => $promo
          ];
        */
       //se envia el array y la vista lo recibe en llaves individuales {{ $email }} , {{ $subject }}...
       \Mail::send('emails.contacto', $data, function($message) use ($request)
       
       {
           //remitente
           //$message->from($request->email, $request->name);
           $message->from('info@saintjosephweb.com.ar', 'Saint Joseph - Turismo aventura');

           //asunto
           $message->subject('Contacto desde Saint Joseph');

           //destinatarios
            
             $config = Config::where(['id'=>1])->first();

             $destinatarios = explode(',', $config->destinatarios);

             foreach ($destinatarios as $destinatario) {
                $message->to($destinatario, 'Saint Joseph');  
              }

            $message->to($request->email, $request->nombre);
      
            //$message->to(env('CONTACT_MAIL'), env('CONTACT_NAME'));

       });

    return '<div class="mensaje-consulta"><span style="font-size:30px"></span><br>GRACIAS POR TU CONSULTA! <br> PRONTO TE CONTACTAREMOS!!!</div>';
    
  }


  public function viewTarifas() {

      $paquetes = Paquete::where('estado',1)->where('tipo',1)->orderBy('orden','asc')->get();

      $config = Config::where(['id'=>1])->first();

      return view('tarifas')->with([
          'paquetes' => $paquetes,
          'config' => $config,
          'tipo' => 1
      ]);
  
  }

  public function viewCheckout() {

      $total_descuento = 0;
      $total_a_pagar = 0;
      $total_sin_desc = 0;
      $cantEntradas = 0;

    if (session()->has('cart')) {

        foreach(session()->get('cart') as &$value) {

          $precio = $value['precio'] * $value['cantidad'];
          $total_sin_desc = $total_sin_desc + $precio;
          $cantEntradas = $cantEntradas + $value['cantidad']; // para verificar cupo

        }
    
        //$dto = Controller::checkDescuento(); //
        //$total_descuento = $total_sin_desc * $dto / 100; // con %
        //$total_descuento = $dto;
        //$total_a_pagar = $total_sin_desc - $total_descuento;

         if (session()->has('discount')) {
            $total_descuento = session()->get('discount');
         }
      
         $total_a_pagar = $total_sin_desc - $total_descuento;

        $config = Config::where(['id'=>1])->first(); //get external_reference
       
        $external_reference = $config->external_reference;

        //session()->put('external_reference', $external_reference);
        session()->put('reserva_save', 0);

        Config::where(['id'=>1])->update([
          'external_reference' => $external_reference + 1,
        ]);
   
      /* INICIO MERCADOPAGO */
      //require_once '../vendor/autoload.php'; // You have to require the library from your Composer vendor folder

      $mp = \MercadoPago\SDK::setAccessToken( env('ENV_ACCESS_TOKEN') ); // Either Production or SandBox AccessToken

      // Crea un objeto de preferencia
      $preference = new \MercadoPago\Preference();

      // Crea un ítem en la preferencia
      $item = new \MercadoPago\Item();
      $item->title = 'Actividades Saint Joseph';
      $item->quantity = 1;
      $item->unit_price = $total_a_pagar;
      $preference->items = array($item);
      $preference->notification_url = url('webhooks');
      $preference->external_reference = $external_reference;

      $preference->back_urls = array(
          "success" => url('gracias'),
          "failure" => url('gracias'),
          "pending" => url('gracias')
      );

      $preference->auto_return = "approved"; 

      $preference->save();

      /* Coinbase */

      /**
       * Init ApiClient with your Api Key
       * Your Api Keys are available in the Coinbase Commerce Dashboard.
       * Make sure you don't store your API Key in your source code!
       */
  
      ApiClient::init("9e598e8f-ae8b-4f49-b3fc-409d56843666");

      $checkoutObj = new Checkout([
        "description" => "Actividades Saint Joseph",
        "local_price" => [
            "amount" => $total_a_pagar,
            "currency" => "ARS"
        ],
        "name" => "Actividades Saint Joseph",
        "pricing_type" => "fixed_price",
        "requested_info" => []
      ]);

      try {
          $checkoutObj->save();
          //echo '<pre>'.sprintf("Successfully created new checkout with id: %s \n", $checkoutObj->id).'</pre>';
      } catch (\Exception $exception) {
          //echo sprintf("Enable to create checkout. Error: %s \n", $exception->getMessage());
      }

      session()->put('pref_id', $preference->id);

      session()->put('total_sin_desc', $total_sin_desc); 
      session()->put('total_descuento', $total_descuento);
      session()->put('total_a_pagar', $total_a_pagar);

      //session()->put('tipo', $tipo);
     
        return view('checkout')->with([
          'total_descuento' => $total_descuento,
          'total_a_pagar' => $total_a_pagar,
          'preferenceId' => $preference->id,
          'textoCheckout' => $config->textoCheckout,
          'checkoutObj' => $checkoutObj,
          'external_reference' => $external_reference,
          'preference' => $preference,
        ]);


    } //fin si hay cart session

    else { 
    
      return redirect('/');
    
    }
      
  }


  public function gracias(Request $request) {

    if ( isset($_REQUEST['collection_id']) ) {
        
        //echo 'status:'.$_REQUEST['collection_status'];

        switch ( $_REQUEST['collection_status'] ) {
          
          case 'approved':
            
            $texto = '<h2 style="text-align: center;"><i class="fa fa-check" aria-hidden="true"></i></h2>
            <h3 style="text-align: center; line-height: 1.5;">¡Muchas gracias! Hemos recibido el Pago sobre la Reserva de las actividades exitosamente.</h3><br>
            <h4 style="text-align: center;">En breve recibirás un email con información detallada, en caso de no recibir, favor de comunicarse.</h4>';

            Controller::receive_ipn(); 

            break;

          case 'pending':
      
            $texto ='<h2 style="text-align: center;"><i class="fa fa-check" aria-hidden="true"></i></h2>
           <h3>¡Muchas gracias! Hemos recibido tu Reserva pero el pago esta aun pendiente de acreditarse, te comunicaremos en cuanto recibamos el pago.</h3>';
            
          break;

          default:
            $texto = 'error!';
            break;
        }

     } 

     session()->forget('cart');
     session()->flush();

    return view('gracias')->with([
        'texto' => $texto,
    ]);

  }
      

  public function receive_ipn() { 

    \MercadoPago\SDK::setAccessToken( env('ENV_ACCESS_TOKEN') );

    $merchant_order = null;

    if (isset($_GET["id"])) {$id = $_GET["id"];}

    if (isset($_REQUEST['collection_id'])) {$id = $_REQUEST['collection_id'];}

    $payment = \MercadoPago\Payment::find_by_id($id);
    // Get the payment and the corresponding merchant_order reported by the IPN.
    $merchant_order = \MercadoPago\MerchantOrder::find_by_id($payment->order->id);

    Reserva::where(['external_reference' => $payment->external_reference])->update([
      'collection_id' => $payment->collector_id,
      'collection_status' => $payment->status,
      'payment_type' => $payment->payment_type_id,
      'estado' => 1,
    ]);

    $reserva = Reserva::where(['external_reference' => $payment->external_reference])->first();

    //envio email

      if ($reserva->emailSend == 0) { //emailSend en 1 significa email ya enviado
          
      /* TOTALES  */

       if ($reserva->descuento > 0) {
        $totales = "
          <p>Total: <b>$ ".number_format($reserva->precio,2, ',', '.')."</b></p> 
          <p>Descuento: <b>$ ".number_format($reserva->descuento,2, ',', '.')."</b></p> 
          <p><b>TOTAL: $ ".number_format($reserva->total,2, ',', '.')."</b></p>";
        } else {
          $totales = "<p><b>TOTAL: $ ".number_format($reserva->total,2, ',', '.')."</b></p>";
        }
      
    /* ACTIVIDADES  */
    $actividades = ReservaActividad::getActividadesPaqueteGracias($reserva->id); // elif x 2

    $config = Config::where(['id'=>1])->first();
        
      $data = [ 
        'reserva' => $reserva,
        'totales' => $totales,
        'actividades' => $actividades,
        'textoEmail' => $config->textoEmail,
      ]; 


      //se envia el array y la vista lo recibe en llaves individuales {{ $email }} , {{ $subject }}...
      \Mail::send('emails.reserva', $data, function($message) use ($reserva, $payment, $config) {
      
          //remitente
          $message->from('info@saintjosephweb.com.ar', 'Saint Joseph - Turismo aventura');
          
          //asunto
          $message->subject('RESERVA Saint Joseph');
      
          //destinatarios
          $destinatarios = explode(',', $config->destinatarios);
          foreach ($destinatarios as $destinatario) {
              $message->to($destinatario, 'Reservas Saint Joseph');  
          }
          $message->to($reserva->email, $reserva->titular);  
        
      });

      /*
        Reserva::where(['external_reference' => $payment->external_reference])->update([
          'emailSend' => 1, //marco 1 email enviado
        ]);
      */
        
      } // endif email enviado

    // Check mandatory parameters
    if (!isset($_GET["id"], $_GET["topic"]) || !ctype_digit($_GET["id"])) {
      http_response_code(400);
      return;
    }

  }

}


