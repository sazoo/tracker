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
				$data[$i]['buy_four_ema'] = $ticker['buy_four_ema'];
				$data[$i]['sell_four_ema'] = $ticker['sell_four_ema'];
				
				//compute 4-EMA diff
				if(sizeOf($tickersArr) >= 4){
					$diffBuy = (($prevBuyFourEMA - $ticker['buy_four_ema'])*100)/$prevBuyFourEMA;
					$diffSell = (($prevBuyFourEMA - $ticker['buy_four_ema'])*100)/$prevBuyFourEMA;
					
					$data[$i]['buy_four_prcnt_diff'] = $diffBuy;
					$data[$i]['sell_four_prcnt_diff'] = $diffSell;
				}else{
					$data[$i]['buy_four_prcnt_diff'] = '';
					$data[$i]['sell_four_prcnt_diff'] = '';
				}
			$prevBuyFourEMA = $ticker['buy_four_ema'];
			$prevSellFourEMA = $ticker['sell_four_ema'];
		$i++;
		}
		return view('home')->with('data', $data);
	}
}
