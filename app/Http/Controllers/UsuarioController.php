<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Auth;
use Session;
use Image;
use App\User;
use App\Fun;
use Illuminate\Support\Facades\Hash;
use Yajra\Datatables\Datatables;

class UsuarioController extends Controller {
   
    public function viewUsuarios() {
        return view('admin.usuarios.view_usuarios');
    }

    public function getData() {
    
        $users = User::select();

        return Datatables::of($users)
 
            ->addColumn('nombre', function ($user) {
                return "<a href='edit-usuario/$user->id'>$user->name</a>"; 
            })

            ->addColumn('estado', function ($user) {
                return Fun::getIconStatus($user->estado); 
            })

            ->addColumn('acciones', function ($user) {
                return "<a href='delete-usuario/$user->id' class='delReg'><i class='fa fa-trash-o' aria-hidden='true'></i></a>";               
            })

            ->rawColumns(['nombre','estado','acciones'])
            ->make(true);
        
    }
    
    /*********************************************************/
    /*                      A D D                            */
    /*********************************************************/
    
    public function addUsuario(Request $request) {
    	
    	if ($request->isMethod('post')) {
    		$data = $request->all();
    		//echo "<pre>"; print_r($data); die;
    		$usuario = new User();
    		$usuario->name = $data['name'];
            $usuario->email = $data['email'];
    		$usuario->estado = $data['estado'];
            $usuario->password = bcrypt($data['password']);
	
    		$usuario->save();
    		return redirect('/admin/view-usuarios')->with('flash_message','Usuario creado correctamente...');
    	}

       return view('admin.usuarios.add_usuario');
    }

    /*********************************************************/
    /*                      E D I T                          */
    /*********************************************************/

    public function editUsuario(Request $request, $id = null) {

        if ($request->isMethod('post')) {

            $data = $request->all();
            
            User::where(['id'=>$id])->update([
                'name' => $data['name'],
                'email' => $data['email'],
                //'password' => bcrypt($data['password']),
                'estado' => $data['estado'],
                ]);

            return redirect('/admin/view-usuarios')->with('flash_message','Usuario actualizado correctamente...');
        }

        $usuario = User::where(['id'=>$id])->first();
       
        return view('admin.usuarios.edit_usuario')->with(compact('usuario'));
    
    }

    /*********************************************************/
    /*                   D E L E T E                       */
    /*********************************************************/

    public function deleteUsuario(Request $request, $id = null) {

        if (!empty($id)) {
            User::where(['id'=>$id])->delete();
            return redirect('/admin/view-usuarios')->with('flash_message','Usuario eliminado...');
        }

        return view('admin.view_usuarios');
    
    }


}
