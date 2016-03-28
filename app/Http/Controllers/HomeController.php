<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ticker;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function showDashboard(){		
		$tickersArr = Ticker::orderBy('created_at', 'DESC')->take(24)->get();
		
		$reversedData = $tickersArr->reverse();
		return view('home')->with('data', $reversedData);
	}
}
