<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class PhotoController extends Controller
{
    //
	
	public function index(Request $request){
		$request->session()->put('key', 'value');
		$value = $request->session()->get('key');
		print_r($value);
	}
}
