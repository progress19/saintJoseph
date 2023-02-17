<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Auth;
use Session;
use Image;
use App\ImgsHome;
use App\Fun;
use Yajra\Datatables\Datatables;

class ImgsHomeController extends Controller {


    public function getData() {
               
        $imagenes = ImgsHome::select();

        return Datatables::of($imagenes)

            ->addColumn('imagen', function ($imagen) {
                return '<img src=" '.asset( Fun::getPathImage('large','imgsHome',$imagen->imagen)).' " class="img-responsive" style="height:100px" >';
            })

            ->addColumn('acciones', function ($imagen) {
                return "<a href='delete-imgHome/$imagen->id' class='delReg'><i class='fa fa-trash-o' aria-hidden='true'></i></a>";
            })
            
            ->addColumn('estado', function ($imagen) {
                return Fun::getIconStatus($imagen->estado); 
            })

            ->rawColumns(['imagen','estado','acciones'])

            ->make(true);

    }    
    
    /*********************************************************/
    /*                      V I E W                          */
    /*********************************************************/

    public function viewImgsHome() {

        $imagenes = ImgsHome::orderBy('id','desc')->get();
        return view('admin.imgsHome.view_imgsHome')->with(compact('imagenes'));
    
    }
    
    /*********************************************************/
    /*                      A D D                            */
    /*********************************************************/
    
    public function addImgHome(Request $request) {
    	
    	if ($request->isMethod('post')) {

    		$data = $request->all();

    		$imagen = new ImgsHome;
            //$imagen->estado = $data['estado'];

            //upload image destacada
            if ($request->hasFile('imagen')) {

                $image_tmp = $request->file('imagen');
                if ($image_tmp->isValid()) {
                                        
                    $extension = $image_tmp->getClientOriginalExtension();
                    $filename = rand(0000000,9999999).'.'.$extension;
                    
                    //Resize image
                    Image::make($image_tmp)->resize(1280,960)->save(Fun::getPathImage('large','imgsHome',$filename));
                    //Image::make($image_tmp)->save(Fun::getPathImage('large','imgsHome',$filename));

                    //Store
                    $imagen->imagen = $filename;
                }
            }

    		$imagen->save();

            return redirect('/admin/view-imgsHome')->with('flash_message','Imagen creada correctamente...');
            
            }            
          
        return view('admin.imgsHome.add_imgHome');

    }

    /*********************************************************/
    /*                      E D I T                          */
    /*********************************************************/

    public function editImgHome(Request $request, $id = null) {

        if ($request->isMethod('post')) {

            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
          
            //upload image destacada
            if ($request->hasFile('imagen')) {

                $image_tmp = $request->file('imagen');
                if ($image_tmp->isValid()) {
                                        
                    $extension = $image_tmp->getClientOriginalExtension();
                    $filename = rand(0000000,9999999).'.'.$extension;
                    
                    //Resize image
                    Image::make($image_tmp)->save(Fun::getPathImage('large','imgsHome',$filename)); //1600*500
                }

            } else {$filename = $data['current_imagen'];}

            ImgsHome::where(['id'=>$id])->update([
                'imagen' => $filename,
                'estado' => $data['estado'],
                ]);
            
            return redirect('/admin/view-imgsHome')->with('flash_message','Imagen actualizada correctamente...');
        }

        $imagen = ImgsHome::where(['id'=>$id])->first();

        return view('admin.imgsHome.edit_imgHome')->with(compact('imagen'));
    
    }

    /*********************************************************/
    /*                   D E L E T E                         */
    /*********************************************************/

    public function deleteImgHome(Request $request, $id = null) { 

        if (!empty($id)) {
            ImgsHome::where(['id'=>$id])->delete();
            return redirect('/admin/view-imgsHome')->with('flash_message','Imagen eliminada...');
        }

        //$destacados = ImgsHome::get();
        //return view('admin.destacados.view_destacados')->with(compact('destacados'));
    
    }


}
