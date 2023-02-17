<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reserva extends Model {

    protected $table = "reservas";

    public function turnorel()   {
        return $this->belongsTo('App\Turno', 'turno')->orderBy('texto');
    }

    public static function getVendidasPorDiaPorTurno($fecha, $turno) {

        $reservas = Reserva::where('fecha', '=', $fecha)->where('turno', '=',  $turno)->where('estado', '=', 1)->get();
        $cantidad = 0;
        foreach ($reservas as $reserva) {
            $cantidad = $cantidad + $reserva->entradas;
        }
        return $cantidad;
    }

    public static function getVendidasPorDiaPorTipo($fecha, $tipo) {

        $reservas = Reserva::where('fecha', '=', $fecha)->where('tipo', '=',  $tipo)->where('estado', '=', 1)->get();
        $cantidad = 0;
        foreach ($reservas as $reserva) {
            $cantidad = $cantidad + $reserva->entradas;
        }
        return $cantidad;
    }

    public static function getPagoStatus($id, $fpago) {
//return $fpago;

        $reserva = Reserva::find($id);

        switch ($fpago) {
            
            case '1':  // 1:mp / 2:crypto 

                switch ( $reserva->collection_status ) {
                    case 'approved':
                        return '<span class="pago-aprobado"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> APROBADO';
                        break;
                    case 'rejected':
                        return '<span class="pago-rechazado"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> RECHAZADO';
                        break;
                    case 'pending':
                        return '<span class="pago-pendiente"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> PENDIENTE';
                        break;
                    case 'in_process':
                        return '<span class="pago-proceso"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span> EN PROCESO';
                        break;
                    case 'cancelado':
                        return '<span class="pago-cancelado"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> CANCELADO';
                        break;
                    default:
                        return '<span class="pago-sinestado"><span class="glyphicon glyphicon-warning-sign" title="Estado desconocido" aria-hidden="true"></span> S/E';
                    break;
                }
                
                break;

            case '2':

                switch ( $reserva->collection_status ) {
                    case 'charge:confirmed':
                        return '<span class="pago-aprobado"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> APROBADO';
                        break;
                    case 'rejected':
                        return '<span class="pago-rechazado"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> RECHAZADO';
                        break;
                    case 'charge:pending':
                        return '<span class="pago-pendiente"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span> PENDIENTE';
                        break;
                    case 'in_process':
                        return '<span class="pago-proceso"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span> EN PROCESO';
                        break;
                    case 'charge:failed':
                        return '<span class="pago-rechazado"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> CANCELADO';
                        break;
                    default:
                        return '<span class="pago-sinestado"><span class="glyphicon glyphicon-warning-sign" title="Estado desconocido" aria-hidden="true"></span> S/E';
                    break;
                }

                break;

        }

    }

public static function getTipoPago($fpago) {

    switch ($fpago) {
        
        case 'mp':
            echo '<img src="'.URLRAIZ.'/images/mercado-pago-logo.png" width="100px" style="padding:0px 13px" >';
            break;

        case 'pp':
            echo '<img src="'.URLRAIZ.'/images/paypal-logo.png" width="90px" style="padding:0px 13px" >';
            break;  

        case 'crypto':
            echo '<img src="'.URLRAIZ.'/images/coinbase-logo.png" width="100px" style="padding:0px 13px" >';
            break;  
        
        default:
            echo '!';
            break;
    
    }

}

}
