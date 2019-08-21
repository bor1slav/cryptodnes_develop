<?php

namespace App\Console\Commands;

use App\Modules\Coins\Models\Coin;
use CoinGecko\Helpers\CoinGecko;
use Illuminate\Console\Command;

class FeedCoinsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'gecko:coins';
    private $api;

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
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Spatie\MediaLibrary\Exceptions\FileCannotBeAdded
     */
    public function handle()
    {
        $already_added_coins = Coin::select('api_key')->get()->pluck('api_key')->toArray();
        $coins = $this->api->coinList();
        foreach ($coins as $coin) {

            if (in_array($coin->id, $already_added_coins)) {
                continue;
            }

            try {
            $coin_data = $this->api->coin($coin->id, [
                'localization' => 'false',
                'tickers' => 'false',
                'market_data' => 'false',
                'community_data' => 'false',
                'developer_data' => 'false',
                'sparkline' => 'false',
            ]);
            } catch (\Exception $exception) {
                $this->info($exception->getMessage());
                //add to logs
                sleep(10);
            }

            $new_data =  [
                'bg' => [
                    'title' => $coin_data['name'],
//                    'description' => $coin_data['description']->en,
                    'slug' => $coin->id
                ]
            ];
//
            $links = (array) $coin_data['links'];

            if (!empty(array_filter($links['homepage']))) {
                $new_data['homepage'] = array_filter($links['homepage']);
            }

            if (!empty(array_filter((array) $links['repos_url']))) {
                $new_data['repos_url'] = array_filter((array) $links['repos_url']);
            }

            if (!empty(array_filter($links['blockchain_site']))) {
                $new_data['blockchain_sites'] = array_filter($links['blockchain_site']);
            }

            $social_links = null;

            if (!empty($links['twitter_screen_name'])) {
                $social_links['twitter'] = 'https://twitter.com/' . $links['twitter_screen_name'];
            }

            if (!empty($links['facebook_username'])) {
                $social_links['facebook'] = 'https://www.facebook.com/' . $links['facebook_username'];
            }

            if (!empty($links['subreddit_url'])) {
                $social_links['reddit'] = $links['subreddit_url'];
            }

            $new_data['social_links'] = $social_links;



            $coin_model = new Coin();
            $coin_model->api_key = $coin->id;
            $coin_model->symbol = $coin->symbol;
            $coin_model->fill($new_data);
            $coin_model->save();

            $images = (array) $coin_data['image'];
            if (!empty($images)) {
                $url = null;
                if  (!empty($images['large'])) {
                    $url = $images['large'];
                }

                if  (!empty($images['large']) && !empty($url)) {
                    $url = $images['small'];
                }

                if (!empty($url) && filter_var($url, FILTER_VALIDATE_URL)) {
                    try {
                    $coin_model->addMediaFromUrl($url)->usingFileName($coin->id . '-' .uniqid())->usingName($coin->id . '-' .uniqid())->toMediaCollection();
                    } catch (\Exception $exception) {
                        $this->info($exception->getMessage());
                    }
                }

            }

            $this->info('Coin imported - ' . $coin->id);
        }
    }
}
