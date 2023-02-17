<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

use Illuminate\Http\Request;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use \MercadoPago\Item;
use \MercadoPago\MerchantOrder;
use \MercadoPago\Payer;
use \MercadoPago\Payment;
use \MercadoPago\Preference;
use \MercadoPago\SDK;

use App\Reserva;
use App\ReservaActividad;
use App\Config;

class WebhooksController extends Controller {

    public function __invoke(Request $request) {

        $payment_id = $_REQUEST['id'];

        // env('ENV_ACCESS_TOKEN')
        // de test : APP_USR-3618598695645197-080322-2db74c93cbed4cf021a2a8622d5a6315-793278417

        $payment = Http::get('https://api.mercadopago.com/v1/payments/' .$payment_id . '?access_token='.env('ENV_ACCESS_TOKEN'));

        $payment = json_decode($payment);

        Reserva::where(['external_reference' => $payment->external_reference])->update([
            'txn_id' => $payment_id,
            'collection_id' => $payment->collector_id,
            'collection_status' => $payment->status,
            'payment_type' => $payment->payment_type_id,
            'estado' => 1, 
        ]);

        if ($payment->status == 'approved') {

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
                    $message->subject('Reserva Saint Joseph');
                //destinatarios
                    $destinatarios = explode(',', $config->destinatarios);
                    foreach ($destinatarios as $destinatario) {
                        $message->to($destinatario, 'saintjosephweb.com.ar');  
                    }

                    $message->to($reserva->email, $reserva->titular);  
                    
                });

                Reserva::where([
                'external_reference' => $payment->external_reference])->update([
                'emailSend' => 1, //marco 1 email enviado
                ]);

            } // endif email enviado

            // Check mandatory parameters
            if (!isset($_GET["id"], $_GET["topic"]) || !ctype_digit($_GET["id"])) {
                http_response_code(400);
                return;
            }

}}}

