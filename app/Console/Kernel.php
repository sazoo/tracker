<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Ticker;
use Illuminate\Support\Facades\App;

use GuzzleHttp\Client;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        // Commands\Inspire::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
		 $schedule->call(function () {
			 
			$t = new Ticker;
            $client = new Client();
			$response = $client->get('http://btcexchange.ph/api/ticker');
			$responseArr = json_decode($response->getBody(), true);
			$t->high = $responseArr['high'];
			$t->last = $responseArr['last'];
			$t->timestamp = $responseArr['timestamp'];
			$t->bid = $responseArr['bid'];
			$t->volume = $responseArr['volume'];
			$t->low = $responseArr['low'];
			$t->ask = $responseArr['ask'];
			$t->open = $responseArr['open'];
			$t->average = $responseArr['average'];
			
			$tickersCount = Ticker::count();
			
			//compute for 4-EMA BUY
			$fourEMA = 0;
			if($tickersCount <= 2){
				$t->buy_four_ema = '';
			} else if($tickersCount == 3){
				$tickers = Ticker::orderBy('created_at', 'ASC')->get();
				foreach($tickers as $ticker){
					$fourEMA = $fourEMA + $ticker->bid;
				}
				$t->buy_four_ema = ($t->bid + $fourEMA)/4;
			}else{
				$lastTicker = Ticker::orderBy('created_at', 'DESC')->first();
				$fourEMA = (($t->bid - $lastTicker->buy_four_ema)*.4) + $lastTicker->buy_four_ema;
				$t->buy_four_ema = $fourEMA;
			}
			
			$lastTicker = Ticker::orderBy('created_at', 'DESC')->first();
			//compute for 4-EMA SELL
			$fourEMA = 0;
			if($tickersCount <= 2){
				$t->sell_four_ema = '';
			} else if($tickersCount == 3){
				$tickers = Ticker::orderBy('created_at', 'ASC')->get();
				foreach($tickers as $ticker){
					$fourEMA = $fourEMA + $ticker->ask;
				}
				$t->sell_four_ema = ($t->ask + $fourEMA)/4;
			}else{
				$fourEMA = (($t->ask - $lastTicker->sell_four_ema)*.4) + $lastTicker->sell_four_ema;
				$t->sell_four_ema = $fourEMA;
			}
			
			//compute for 24-EMA buy
			$twentyFourEMA = 0;
			if($tickersCount <= 22){
				$t->buy_four_ema = '';
			} else if($tickersCount == 23){
				$tickers = Ticker::orderBy('created_at', 'ASC')->get();
				foreach($tickers as $ticker){
					$twentyFourEMA = $twentyFourEMA + $ticker->bid;
				}
				$t->buy_twenty_four_ema = ($t->bid + $twentyFourEMA)/24;
			}else{
				$lastTicker = Ticker::orderBy('created_at', 'DESC')->first();
				$twentyFourEMA = (($t->bid - $lastTicker->buy_twenty_four_ema)*.08) + $lastTicker->buy_twenty_four_ema;
				$t->buy_twenty_four_ema = $twentyFourEMA;
			}
			
			//compute for 24-EMA SELL
			$twentyFourEMA = 0;
			if($tickersCount <= 2){
				$t->sell_twenty_four_ema = '';
			} else if($tickersCount == 3){
				$tickers = Ticker::orderBy('created_at', 'ASC')->get();
				foreach($tickers as $ticker){
					$twentyFourEMA = $twentyFourEMA + $ticker->ask;
				}
				$t->sell_twenty_four_ema = ($t->ask + $twentyFourEMA)/4;
			}else{
				$twentyFourEMA = (($t->ask - $lastTicker->sell_twenty_four_ema)*.08) + $lastTicker->sell_twenty_four_ema;
				$t->sell_twenty_four_ema = $twentyFourEMA;
			}
			
			//RSI
			if($tickersCount == 0){
				$t->gain = $t->ask;
				$t->loss = 0;
			}else{
				if($t->ask > $lastTicker->ask){
					$t->gain = $t->ask;
				}else{
					$t->gain = 0;
				}
				
				if($t->ask > $lastTicker->ask){
					$t->loss = 0;
				}else{
					$t->loss = $t->ask;
					
				}
			}
			
			//ave gain
			$aveGain = 0;
			if($tickersCount <= 5){
				$t->ave_gain = '';
			}else if($tickersCount == 6){
				$tickers = Ticker::orderBy('created_at', 'ASC')->get();
				foreach($tickers as $ticker){
					$aveGain = $aveGain + $ticker->gain;
				}
				$t->ave_gain = ($t->gain + $aveGain)/7;
			}else{
				$t->ave_gain = (($lastTicker->ave_gain * 6) + $t->gain)/7;
			}
			
			//ave loss
			$aveLoss = 0;
			if($tickersCount <= 5){
				$t->ave_loss = '';
			}else if($tickersCount == 6){
				$tickers = Ticker::orderBy('created_at', 'ASC')->get();
				foreach($tickers as $ticker){
					$aveLoss = $aveLoss + $ticker->loss;
				}
				$t->ave_loss = ($t->loss + $aveLoss)/7;
			}else{
				$t->ave_loss = (($lastTicker->ave_loss * 6) + $t->loss)/7;
			}
			
			//compute RSI
			if($tickersCount > 6){
				$t->rsi = 100 - (100/(1 + ($t->ave_gain - $t->ave_loss)));
			}
			
			//compute diff four
			if($tickersCount > 0){
				if($lastTicker->buy_four_ema != null){
					$t->buy_four_diff = (($t->buy_four_ema - $lastTicker->buy_four_ema )*100)/$lastTicker->buy_four_ema;
				}
				if($lastTicker->sell_four_ema != null){
					$t->sell_four_diff = (($t->sell_four_ema - $lastTicker->sell_four_ema)*100)/$lastTicker->sell_four_ema;
				}
			}
			
			//compute diff twenty four
			if($tickersCount > 0){
				if($lastTicker->buy_twenty_four_ema != null){
					$t->buy_twenty_four_diff = (($t->buy_twenty_four_ema - $lastTicker->buy_twenty_four_ema )*100)/$lastTicker->buy_twenty_four_ema;
				}
				if($lastTicker->sell_twenty_four_ema != null){
					$t->sell_twenty_four_diff = (($t->sell_twenty_four_ema - $lastTicker->sell_twenty_four_ema)*100)/$lastTicker->sell_twenty_four_ema;
				}
			}
			
			
			$t->save();
			
			$pusher = App::make('pusher');

			$pusher->trigger( 'ticker',
							  'new_ticker', 
							  array('text' => $t->toJson()));
			
        })->everyFiveMinutes();
    }
}
