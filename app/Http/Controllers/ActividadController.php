<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Actividad;
use App\Fun;
use Yajra\Datatables\Datatables;
use Image;

class ActividadController extends Controller {

    public function getData() {
               
        $actividades = Actividad::select();

        return Datatables::of($actividades)

            ->addColumn('imagen_raw', function ($actividad) {
                $img = asset( Fun::getPathImage('large','actividad',$actividad->imagen));
                return '<img style="max-height:50px" src="'.$img.'">'; 
            })
            
            ->addColumn('nombre', function ($actividad) {
                return "<a href='edit-actividad/$actividad->id'>$actividad->nombre</a>"; 
            })

            ->addColumn('tipo', function ($actividad) {
                return $actividad->tipo === 2 ? "<span class='badge badge-dark'>Destacado</span>" : "<span class='badge badge-primary'>Común</span>";  
            })

            ->addColumn('estado', function ($actividad) {
                return Fun::getIconStatus($actividad->estado); 
            })

            ->addColumn('venta_raw', function ($actividad) {
                return Fun::getIconStatus($actividad->venta); 
            })

            ->addColumn('acciones', function ($actividad) {
                return "<a href='delete-actividad/$actividad->id' class='delReg'><i class='fa fa-trash-o' aria-hidden='true'></i></a>";
            })

            ->addColumn('adulto_raw', function ($actividad) {
                return '$'.$actividad->precio_a; 
            })

            ->addColumn('menor_raw', function ($actividad) {
                return '$'.$actividad->precio_b; 
            })

            ->addColumn('estado', function ($actividad) {
                return Fun::getIconStatus($actividad->estado); 
            })

            ->rawColumns(['nombre','estado','acciones','tipo','imagen_raw','precio_a','precio_b','venta_raw'])

            ->make(true);

    }

    public function viewActividades() {

        $actividades = Actividad::orderBy('nombre','asc')->get();
        return view('admin.actividades.view_actividades')->with(compact('actividades'));
    }

    /*********************************************************/
    /*                      A D D                            */
    /*********************************************************/
    
    public function addActividad(Request $request) {
        
        if ($request->isMethod('post')) {
            $data = $request->all();

            $actividad = new Actividad;
            $actividad->nombre = $data['nombre'];
            $actividad->precio_a = $data['precio_a'];
            $actividad->precio_b = $data['precio_b'];
            $actividad->orden = $data['orden'];
            $actividad->tipo = $data['tipo'];
            $actividad->temporada = $data['temporada'];
            $actividad->lugar = $data['lugar'];
            $actividad->dificultad = $data['dificultad'];
            $actividad->descripcion = $data['descripcion'];
            $actividad->duracion = $data['duracion'];
            $actividad->venta = $data['venta'];
            $actividad->estado = $data['estado'];

            //upload image
            if ($request->hasFile('imagen')) {

                $image_tmp = $request->file('imagen');
                if ($image_tmp->isValid()) {
                                        
                    $extension = $image_tmp->getClientOriginalExtension();
                    $filename = rand(0000000,9999999).'.'.$extension;
                 
                    //dd(Fun::getPathImage('large','actividad',$filename));

                    //Resize image
                    //Image::make($image_tmp)->resize(960,600)->save(Fun::getPathImage('large','actividad',$filename));
                    Image::make($image_tmp)->save(Fun::getPathImage('large','actividad',$filename));

                    //Store
                    $actividad->imagen = $filename;
                }
            }
    
            $actividad->save();
            return redirect('/admin/view-actividades')->with('flash_message','Actividad creada correctamente...');
        }

       return view('admin.actividades.add_actividad');
    }

    /*********************************************************/
    /*                      E D I T                          */
    /*********************************************************/

    public function editActividad(Request $request, $id = null) {

        if ($request->isMethod('post')) {

            $data = $request->all();
            //echo "<pre>"; print_r($data); die;

            //upload imagen
            if ($request->hasFile('imagen')) {

                $image_tmp = $request->file('imagen');
                if ($image_tmp->isValid()) {
                                        
                    $extension = $image_tmp->getClientOriginalExtension();
                    $filename = rand(0000000,9999999).'.'.$extension;
                    
                    //Resize image
                    Image::make($image_tmp)->save(Fun::getPathImage('large','actividad',$filename));
                }

            } else {$filename = $data['current_imagen'];}
            
            Actividad::where(['id'=>$id])->update([
                'nombre' => $data['nombre'],
                'precio_a' => $data['precio_a'],
                'precio_b' => $data['precio_b'],
                'orden' => $data['orden'],
                'tipo' => $data['tipo'],
                'lugar' => $data['lugar'],
                'temporada' => $data['temporada'],
                'dificultad' => $data['dificultad'],
                'descripcion' => $data['descripcion'],
                'duracion' => $data['duracion'],
                'venta' => $data['venta'],
                'imagen' => $filename,
                'estado' => $data['estado'],
                ]);
            return redirect('/admin/view-actividades')->with('flash_message','Actividad actualizado correctamente...');
        }

        $actividad = Actividad::where(['id'=>$id])->first();
       
        return view('admin.actividades.edit_actividad')->with(compact('actividad'));
    
    }


    /*********************************************************/
    /*                   D E L E T E                       */
    /*********************************************************/

    public function deleteActividad(Request $request, $id = null) {

        if (!empty($id)) {
            Actividad::where(['id'=>$id])->delete();
            return redirect('/admin/view-actividades')->with('flash_message','Actividad eliminada...');
        }

        $actividades = Actividad::get();
        return view('admin.actividades.view_paquetes')->with(compact('actividades'));
    
    }


}
