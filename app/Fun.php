<?php

namespace App;
use Image;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Str;

class Fun extends Model {

	public static function getStatusPayMp($status) {

		switch ($status) {
			case 'pending':
				echo 'Pendiente';
				break;

			case 'approved':
				echo 'Aprobado';
			break;

			case 'in_process':
				echo 'En proceso';
			break;

			case 'rejected':
				echo 'Rechazado';
			break;

			case 'cancelled':
				echo 'Cancelado';
			break;
		
			default:
				echo 'Sin Estado';
				break;
		}

	}

	/*
	Estado del pago
	pending: The user has not yet completed the payment process.
	approved: The payment has been approved and accredited.
	authorized: The payment has been authorized but not captured yet.
	in_process: Payment is being reviewed.
	in_mediation: Users have initiated a dispute.
	rejected: Payment was rejected. The user may retry payment.
	cancelled: Payment was cancelled by one of the parties or because time for payment has expired
	refunded: Payment was refunded to the user.
	charged_back: A chargeback was made in the buyer’s credit card.
	*/

	public static function getPathImage($size, $model, $filename) {
		$pics_path = config('constants.options.pics-path');
		$image_path = $pics_path.$model.'/'.$size.'/'.$filename;
		return $image_path;
	}
	
	public static function getlogoMoneda($currency) {

		switch ($currency) {
			
			case 'BTC':
				return asset('images/logos-crypto/btc.png');
			break;
		
			case 'BCH':
				return asset('images/logos-crypto/bch.png');
			break;

			case 'DAI':
				return asset('images/logos-crypto/dai.png');
			break;

			case 'DOGE':
				return asset('images/logos-crypto/doge.png');
			break;

			case 'ETH':
				return asset('images/logos-crypto/eth.png');
			break;

			case 'LTC':
				return asset('images/logos-crypto/ltc.png');
			break;

			case 'USDC':
				return asset('images/logos-crypto/usdc.png');
			break;
					
		}

	}

	public static function getNombreEstado($estado) {
		switch ($estado) {
			case '0':
				return 'Pendiente';
				break;
		
			case '1':
				return 'Pagado';
			break;
		}
	}

	public static function getTipoNombre($tipo) {
		switch ($tipo) {
			case '1':
				return 'Tienda';
				break;
			case '2':
				return 'Egresados';
			break;
		}
	}

	public static function getTipoPrecio($tipo) {

		switch ($tipo) {
			case '1':
				return 'Mayor';
				break;
		
			case '2':
				return 'Menor';
			break;
					
		}

	}

	public static function checkEstadoBoton($key) {

		if ( session()->has('cart') ) {
		
			$array = session()->get('cart');

			$search = array_key_exists($key, $array);
			if ($search==1) {return 'disabled';	}
		}

	}

	public static function checkTextoBoton($key) {

		if (session()->has('cart')) {
		
			$array = session()->get('cart');
		
			$search = array_key_exists($key, $array);
			
			if ($search==1) {
				return 'En Carrito';
			} else {
				return 'Agregar al carrito';
			}
 
			//return (array_key_exists($key, $array)==1 ? 'EN CARRITO' : 'AGREGAR AL CARRITO');

		} else {
			return 'Agregar al carrito';
		}



	}

	public static function getFormatDateInv($date) { //recupero desde la bd

		$date = explode("-",$date);
        $date = "$date[2]-$date[1]-$date[0]";  
		
		return $date;
	}

	public static function getIconStatus($status) {

		if ($status==1) {return '<i style="font-size:18px;" class="fa fa-check"></i>';} 
			else {return '<i style="font-size:18px;" class="fa fa-times"></i>';}
	}

	public static function getFormatDate($date) {

		$date = explode("-",$date);
        $date = "$date[2]-$date[1]-$date[0]";  
		
		return $date;
	}



}
