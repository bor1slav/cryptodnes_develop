<?php

namespace App\Console\Commands;

use App\Modules\Coins\Models\Coin;
use CoinGecko\Helpers\CoinGecko;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Swap\Laravel\Facades\Swap;

class SyncCoinsDataCommand extends Command
{

    private $api;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gecko:coins:data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->api = new CoinGecko();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
            try {
                $this->api = new CoinGecko();
                //get all coins and chunk them to 100 because api returns 100 coins on a page

                if (empty(Cache::get('rate_usd_old'))) {
                    $this->info('updating currencies - 24h ago UDS/EUR');
                    Cache::put('rate_usd_old', Swap::historical('USD/EUR', Carbon::yesterday())->getValue(), 60 * 60 * 24);
                }
                if (empty(Cache::get('rate_usd_current'))) {
                    $this->info('updating currencies - Latest UDS/EUR');
                    Cache::put('rate_usd_current', Swap::latest('USD/EUR')->getValue(), 60 * 60 * 24);

                }

                $all_coins_count = Coin::count();
                $iteration = 100;
                $rate_usd_old = Cache::get('rate_usd_old');
                $rate_usd_current = Cache::get('rate_usd_current');
                $rate_euro_bgn = 1.96;



                Coin::reversed()->chunk($iteration, function ($coins) use ($iteration, &$count, $all_coins_count, $rate_usd_old, $rate_usd_current, $rate_euro_bgn) {

                    //separate all coin slugs with "," for the api request
                    $coins_string = '';
                    foreach ($coins as $coin) {
                        $coins_string .= $coin->api_key;

                        if ($coin != end($coins)) {
                            $coins_string .= ',';
                        }
                    }

                    //send api request
                    $coins_data = $this->api->coinMarkets('usd', [
                        'ids' => $coins_string,
//                'price_change_percentage' => '1h,24h,7d,30d,1y'
                    ]);

                    $coins_volume = $this->api->simplePrice($coins_string, 'usd', [
                        'include_24hr_vol' => 'true',
                    ]);

                    $coins_filtered_data = [];

                    //add coin id to array key
                    foreach ($coins_data as $data) {
                        $coins_filtered_data[$data->id] = $data;
                    }


                    foreach ($coins as $coin) {


                        if (empty($coins_filtered_data[$coin->api_key])) {
                            continue;
                        }

                        $specific_coin_data = (array)$coins_filtered_data[$coin->api_key];


                        //remove those fields from the array so they don't get updated
                        unset($specific_coin_data['id']);
                        unset($specific_coin_data['symbol']);
                        unset($specific_coin_data['name']);
                        unset($specific_coin_data['image']);
                        unset($specific_coin_data['last_updated']);
                        unset($specific_coin_data['price_change_percentage_24h']);



                        if ((int)$specific_coin_data['total_supply'] > 999999999999999999) {
                            $specific_coin_data['total_supply'] = (int)999999999999999999;
                        }

                        $coin->fill($specific_coin_data);

                        if (!empty($coins_volume[$coin->api_key]) && !empty((array)$coins_volume[$coin->api_key])) {

                            $volume = $coins_volume[$coin->api_key]->usd_24h_vol;
                            $coin->volume_24h = $volume;
                        }

                        $old_price = $specific_coin_data['current_price'] - ($specific_coin_data['price_change_24h']);
                        $coin->old_price_24h = $old_price;

                        $money_in_euro_old = $old_price * $rate_usd_old;
                        $money_in_euro_new = $specific_coin_data['current_price'] * $rate_usd_current;



                        $money_in_bgn_old = $money_in_euro_old * $rate_euro_bgn;
                        $money_in_bgn_new = $money_in_euro_new * $rate_euro_bgn;


//                        $money_in_euro_new = round($money_in_euro_new, strlen(substr(strrchr($specific_coin_data['current_price'], "."), 1)));
//                        $money_in_bgn_new = round($money_in_bgn_new, strlen(substr(strrchr($specific_coin_data['current_price'], "."), 1)));


                        $coin->current_price_euro = $money_in_euro_new;
                        $coin->old_price_24h_euro = $money_in_euro_old;
                        $coin->current_price_bgn = $money_in_bgn_new;
                        $coin->old_price_24h_bgn = $money_in_bgn_old;
                        $coin->price_change_percentage_24h = get_percentage_difference($specific_coin_data['current_price'], $old_price);

                        $coin->save();
                    }
                });

                $this->info(Carbon::now() . ' - Done');
            } catch (\Exception $exception) {
                $this->info($exception->getMessage());
                sleep(10);
            }
        return 1;
    }
}
