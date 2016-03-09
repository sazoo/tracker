<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ticker;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function showDashboard(){		
		$tickers = Ticker::all()->take(24)->get();
		
		
	}
}
