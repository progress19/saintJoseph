<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Auth;
use Session;
use App\Config;
use Image;
use App\Fun;

class ConfigController extends Controller
{
    /*********************************************************/
    /*                      E D I T                          */
    /*********************************************************/

    public function editConfig(Request $request, $id = null) {

        if ($request->isMethod('post')) {

            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            
            $destinatarios = str_replace(' ', '', $data['destinatarios']);
           
            Config::where(['id'=>$id])->update([
                'destinatarios' => $destinatarios,
                'textoCheckout' => $data['textoCheckout'],
                'textoEmail' => $data['textoEmail'],
                'textoNoReserva' => $data['textoNoReserva'],
                'reservas' => $data['reservas'],
               ]);

            return redirect('/admin/dashboard')->with('flash_message','Configuración actualizada correctamente...');

        }

        $config = Config::where(['id'=>$id])->first();
       
        return view('admin.config.edit_config')->with(compact('config'));
    
    }


}

