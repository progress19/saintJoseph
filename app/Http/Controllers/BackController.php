<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Auth;
use Session;
use Image;
use App\Reserva;
use App\Fun;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

use App\Exports\ReservasExport;
use Maatwebsite\Excel\Facades\Excel;

class BackController extends Controller
{

    public function exportarReservas() {

        return Excel::download(new ReservasExport, 'reservasSaintJoseph.xlsx');

    }
   

}
