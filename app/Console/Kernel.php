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
			
			//compute for 4-EMA
			$fourEMA = 0;
			if($tickersCount <= 3){
				$t->buy_four_ema = '';
			} else if($tickersCount == 4){
				$tickers = Ticker::orderBy('created_at', 'ASC')->get();
				foreach($tickers as $ticker){
					$fourEMA = $fourEMA + $ticker->bid;
				}
				$t->buy_four_ema = $fourEMA/4;
			}else{
				$lastTicker = Ticker::orderBy('created_at', 'DESC')->first();
				$fourEMA = (($t->bid - $lastTicker->buy_four_ema)*.4) + $lastTicker->buy_four_ema;
				$t->buy_four_ema = $fourEMA;
			}
			$t->save();
			
			$pusher = App::make('pusher');

			$pusher->trigger( 'ticker',
							  'new_ticker', 
							  array('text' => $t->toJson()));
			
        })->hourly();
    }
}
