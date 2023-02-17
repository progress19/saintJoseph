<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImgsHome extends Model {

	protected $table = "imgs_home";

	public static function getImgsHome() {

		switch (session()->get('idioma')) {
			case 'es':
				$idioma = 1;
				break;
			
			case 'en':
				$idioma = 2;
				break;	

			default:
				$idioma = 1;
				break;
		}

		return ImgsHome::where('estado','=',1)->where('idioma','=',1)->inRandomOrder()->first();
		
	} 

	
    
}
