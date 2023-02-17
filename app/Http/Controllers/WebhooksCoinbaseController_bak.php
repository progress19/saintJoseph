<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

use Illuminate\Http\Request;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use CoinbaseCommerce\ApiClient;
use CoinbaseCommerce\Webhook;
use CoinbaseCommerce\Resources\Charge;

use App\Reserva;
use App\ReservaActividad;
use App\Config;

class WebhooksCoinbaseController extends Controller {

    public function __invoke(Request $request) {

        /**
         * To run this example please read README.md file
         * Past your Webhook Secret Key from Settings/Webhook section
         * Make sure you don't store your Secret Key in your source code!
         */
        $secret = 'adcbf3d8-07dd-48e7-8b8a-270162823d65';
        $headerName = 'X-Cc-Webhook-Signature';
        $headers = getallheaders();
        $signraturHeader = isset($headers[$headerName]) ? $headers[$headerName] : null;
        $payload = trim(file_get_contents('php://input'));

        try {

            $event = Webhook::buildEvent($payload, $signraturHeader, $secret);
        
            Reserva::where(['preference_id' => $event->data['checkout']['id'] ])->update([
                'collection_status' => $event->type , 
                'codeCoinbase' => $event->data['code'],
            ]);

        if ($event->type == 'charge:confirmed') {
            
            $reserva = Reserva::where([ 'preference_id' => $event->data['checkout']['id'] ])->first();

            ApiClient::init("9e598e8f-ae8b-4f49-b3fc-409d56843666");

            $chargeObj = Charge::retrieve($reserva->codeCoinbase); 

            Reserva::where(['preference_id' => $event->data['checkout']['id'] ])->update([
                
                'amount' =>  $chargeObj['payments']['0']['value']['crypto']['amount'],
                'currency' =>  $chargeObj['payments']['0']['value']['crypto']['currency'],
                
            ]);

            $reserva = Reserva::where([ 'preference_id' => $event->data['checkout']['id'] ])->first();

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

                /* TURNO */
                $turnoCodigo = $reserva->turno;
                $turnoTexto = $reserva->turnorel->texto;

                $config = Config::where(['id'=>1])->first();

                if ($reserva->tipo == 1) {$textoEmail = $config->textoEmail;} // tienda
                if ($reserva->tipo == 2) {$textoEmail = $config->textoEmailE;} // egresados

                $data = [ 
                    'reserva' => $reserva,
                    'totales' => $totales,
                    'actividades' => $actividades,
                    'textoEmail' => $textoEmail,
                    'turnoTexto' => $turnoTexto,
                    'turnoCodigo' => $turnoCodigo,
                    'tipoPago' => '2' // 1 - MP / 2 - Coinbase
                ]; 

                //se envia el array y la vista lo recibe en llaves individuales {{ $email }} , {{ $subject }}...
                \Mail::send('emails.reserva', $data, function($message) use ($reserva, $config) {
                //remitente
                    $message->from('noreply@xxxxx.com', 'xxxxxxx.com');
                //asunto
                    $message->subject('RESERVA xxxxxxx xxxxxxx');
                //destinatarios
                    $destinatarios = explode(',', $config->destinatarios);
                    foreach ($destinatarios as $destinatario) {
                        $message->to($destinatario, 'xxxxxxx.com');  
                    }

                    $message->to($reserva->email, $reserva->titular);  
                    
                });

                Reserva::where( ['preference_id' => $event->data['checkout']['id'] ] )->update([
                    'emailSend' => 1, //marco 1 email enviado
                    'estado' => 1,
                ]);

            } // endif email enviado

        }

            http_response_code(200);
            echo sprintf('Successully verified event with id %s and type %s.', $event->id, $event->type);

        } catch (\Exception $exception) {
            http_response_code(400);
            echo 'Error occured. ' . $exception->getMessage();
        }


    }

}

