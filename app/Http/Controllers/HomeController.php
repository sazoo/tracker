<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ticker;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function showDashboard(){		
		$tickersArr = Ticker::orderBy('created_at', 'ASC')->take(24)->get()->toArray();
		
		$i = 0;
		$data = array();
		foreach($tickersArr as $ticker){
			$data[$i]['date'] = $ticker['created_at'];
			$data[$i]['buy_current'] = $ticker['bid'];
			$data[$i]['sell_current'] = $ticker['ask'];
		$i++;
		}
		return view('home')->with('data', $data);
	}
}
