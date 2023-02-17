<?php use App\Fun;

use \MercadoPago\Item;
use \MercadoPago\MerchantOrder;
use \MercadoPago\Payer;
use \MercadoPago\Payment;
use \MercadoPago\Preference;
use \MercadoPago\SDK;

use Illuminate\Support\Facades\Http;

 ?>


<?php


    //  $mp = \MercadoPago\SDK::setAccessToken( env('ENV_ACCESS_TOKEN') ); // Either Production or SandBox AccessToken
/*
      // Crea un objeto de preferencia
      $preference = new \MercadoPago\Preference();

      // Crea un ítem en la preferencia
      $item = new \MercadoPago\Item();
      $item->title = 'Actividades Euca Tigre';
      $item->quantity = 1;
      $item->unit_price = $total_a_pagar;

      $preference->items = array($item);
      $preference->notification_url = url('receive_ipn');
      $preference->external_reference = $external_reference;
      
      $preference->save();

·······················333

    \MercadoPago\SDK::setAccessToken( env('ENV_ACCESS_TOKEN') );

    $merchant_order = null;

    $payment = \MercadoPago\Payment::find_by_id($id);

    echo $payment->collector_id;

*/
/*
curl -X GET \
    'https://api.mercadopago.com/v1/payments/search?sort=date_created&criteria=desc&external_reference=ID_REF' \
    -H 'Authorization: Bearer YOUR_ACCESS_TOKEN' 
*/

$response = Http::get('https://api.mercadopago.com/v1/payments/search?sort=date_created&criteria=desc&external_reference=97' . '?access_token=APP_USR-4782370759525819-122916-d8aba981ec4d8d866260e365eb3b1ab3-136568389');

$response = json_decode($response);

dump($response);

//dd($response);
/*
     $objMercadoPago =  \MercadoPago\SDK::setAccessToken( env('ENV_ACCESS_TOKEN') ); // Either Production or SandBox AccessToken

      $datosjson = $objMercadoPago -> get("/v1/payments/search?external_reference={171}");
*/
      //$mp = new \MercadoPago\Preference();


/*

      // Crea un objeto de preferencia
      $preference = new \MercadoPago\Preference();

      // Crea un ítem en la preferencia
      $item = new \MercadoPago\Item();
      $item->title = 'Actividades Euca Tigre';
      $item->quantity = 1;
      $item->unit_price = $total_a_pagar;

      $preference->items = array($item);
      $preference->notification_url = url('receive_ipn');
      $preference->external_reference = $external_reference;
      
      $preference->save();

*/









/*
$mp = new \MercadoPago\SDK::setAccessToken( env('ENV_ACCESS_TOKEN') ); // Either Production or SandBox AccessToken
//echo  $reserva->external_reference;

//dd($mp);

//$id='121212';

  $payment = \MercadoPago\Payment::find_by_id('369403198');

  print_r($payment);

/*
$paymentId='121212';

  $payment = $mp->get(
    "/v1/payments/". $paymentId
  );
*/

/*
    $payment = \MercadoPago\Payment::find_by_external_reference(211212);

    print_r($payment);
*/
/*
$filters = array ( 

        "id" => null,
        "external_reference" => $reserva->external_reference 

    );

$searchResult = $mp->search_payment($filters,0,1);

print_r ($searchResult);
*/

//$mp = new \MP('ACCESS_TOKEN');
/*
$payment = $mp->get("/v1/payments/search?range=date_created&begin_date=NOW-1MONTH&end_date=NOW&status=approved&operation_type=regular_payment");
return $payment;
*/
?>


 
            

          </div>
        </div>

      </div>



