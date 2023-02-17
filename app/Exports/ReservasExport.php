<?php

namespace App\Exports;

use App\Reserva;
use App\Fun;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

use Carbon\Carbon;

class ReservasExport implements FromQuery, WithMapping, WithHeadings, ShouldAutoSize, WithColumnFormatting
{    
    /**
    * @var Reserva $reserva
    */
   
   use Exportable;

   public function query() {
      return Reserva::query();
   }
 
    public function headings(): array  {
        return [
  
            'id',
            'Fecha de registro',
            'Fecha de actividad',
            'Titular',
            'email',
            'Teléfono',
            'Colegio',
            'Código',
            'Entradas',
            'Tipo',
            'Turno',
            'Precio',
            'Descuento',
            'Total',
            'collection_id',
            'Estado',
                
        	];
    }

    public function map($reserva): array    {
        return [

            $reserva->id,
            Carbon::parse($reserva->fechaReg)->format('d-m-Y H:i').'hs',
            Carbon::parse($reserva->fecha)->format('d-m-Y H:i').'hs',
            $reserva->titular,
            $reserva->email,
            $reserva->telefono,
            $reserva->colegio,
            $reserva->codigo,
            $reserva->entradas,
            Fun::getTipoNombre($reserva->tipo),
            $reserva->turno,
            $reserva->precio,
            $reserva->descuento,
            $reserva->total,
            $reserva->collection_id,
            Fun::getNombreEstado($reserva->estado),
        ];
    }

    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            ];
    }


}

