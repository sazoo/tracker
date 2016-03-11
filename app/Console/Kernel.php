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
				$fourEMA = (($t->ask - $lastTicker->buy_four_ema)*.4) + $lastTicker->sell_four_ema;
				$t->sell_four_ema = $fourEMA;
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
			
			//compute diff
			if($tickersCount > 0){
				if($lastTicker->buy_four_ema != null){
					$t->buy_four_diff = (($t->buy_four_ema - $lastTicker->buy_four_ema)*.4) + $t->buy_four_ema;
				}
				if($lastTicker->sell_four_ema != null){
					$t->sell_four_diff = (($t->sell_four_ema - $lastTicker->sell_four_ema)*.4) + $t->sell_four_ema;
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
