<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PagesController extends Controller
{
	public function index()
	{
		
		$test 	= ['item1', 'item2', 'item3'];
		$test2 	= '<em>Test Name</em>';


		// return home.blade.php view w in views/pages/	
		// return view('pages.home');

		# pass a static variable to a view
		// return view('pages.home')->with('test1', $test1);
		// return view('pages.home', compact('test', 'test2'));
		return view('pages.home', ['test1'=> $test2, 'test2'=>$test]);
	}



	public function about()
	{
		return view('pages.about');
	}

}
