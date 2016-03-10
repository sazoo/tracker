<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ticker;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function showDashboard(){		
		$tickersArr = Ticker::orderBy('created_at', 'ASC')->take(25)->get()->toArray();
		
		$i = 0;
		$data = array();
		foreach($tickersArr as $ticker){
			if($i >= 1){
				$data[$i-1]['date'] = $ticker['created_at'];
				$data[$i-1]['buy_current'] = $ticker['bid'];
				$data[$i-1]['sell_current'] = $ticker['ask'];
				$data[$i-1]['buy_four_ema'] = $ticker['buy_four_ema'];
				
				//compute 4-EMA diff
				$diff = (($prevFourEMA - $ticker['buy_four_ema'])*100)/$prevFourEMA;
				
				$data[$i-1]['buy_four_prcnt_diff'] = $diff;
			}
			$prevFourEMA = $ticker['buy_four_ema'];
		$i++;
		}
		return view('home')->with('data', $data);
	}
}
