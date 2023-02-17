<?php

namespace App;
use App\Paquete;
use App\Fun;

use Illuminate\Database\Eloquent\Model;

class ReservaActividad extends Model {
    
    protected $table = "reservas_actividades";

    public function paquete() 	 {
    	
    	return $this->belongsTo('App\Paquete', 'idActividad')->orderBy('nombre');
    
    }

    public static function getActividadesPaqueteGracias($id) {

    	$actividades = ReservaActividad::where(['idReserva' => $id])->get();

		$th='';

	    foreach ($actividades as $actividad) {

	    	$th = $th.'<tr style="font-size:15px">
		
		    			<th style="text-align:right; height: 23px; width: 5%;padding-right:20px;">
		    				'. $actividad->cantidad .'
		    			</th>

		    			<th style="text-align:left; height: 23px; width: 50%;">
		    				'. $actividad->nombre .' ('.Fun::getTipoPrecio($actividad->precio_tipo).')
		    			</th>

		    			<th style="height: 23px; width: 20%;text-align:right">
		    				$'. number_format($actividad->precio,0, '.', '') .'
		    			</th> 

		    			<th style="height: 23px; width: 25%;text-align:right">
		    				$'. number_format($actividad->precio * $actividad->cantidad,0, '.', '') .'
		    			</th>

	   		  		</tr>';

	    }

	    return '<table>'.$th.'</table>';

	}

	public static function getEntradasCant($id) {

    	$actividades = ReservaActividad::where(['idReserva' => $id])->get();

    	$cantidad = 0;

	    foreach ($actividades as $actividad) {

	    	$cantidad = $cantidad + $actividad->cantidad;

	    }

	    return $cantidad;

	}

}
