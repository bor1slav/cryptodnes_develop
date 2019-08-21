<?php

namespace App\Console\Commands;

use App\Modules\Analyzes\Models\Analyze;
use App\Modules\Analyzes\Models\AnalyzeCategory;
use App\Modules\Blog\Models\Blog;
use App\Modules\Blog\Models\BlogCategory;
use App\Modules\Coins\Models\Coin;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class MigrateOldDatabaseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:old';

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
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Creating needed analyzes categories...');

        $bitcoin_analyze = AnalyzeCategory::whereTranslation('title', 'Биткойн')->first();
        if (empty($bitcoin_analyze)) {
            $bitcoin_analyze = new AnalyzeCategory();
            $bitcoin_analyze->coin_id = Coin::where('symbol', 'btc')->first()->id;
            $bitcoin_analyze->visible = 1;
            $bitcoin_analyze->fill([
                'bg' => [
                    'title' => 'Биткойн Анализ',
                    'meta_title' => 'Биткойн Анализ'
                ]
            ]);
            $bitcoin_analyze->save();
        }

        $ethereum_analyze = AnalyzeCategory::whereTranslation('title', 'Етериум')->first();
        if (empty($ethereum_analyze)) {
            $ethereum_analyze = new AnalyzeCategory();
            $ethereum_analyze->coin_id = Coin::where('symbol', 'eth')->first()->id;
            $ethereum_analyze->visible = 1;
            $ethereum_analyze->fill([
                'bg' => [
                    'title' => 'Етериум Анализ',
                    'meta_title' => 'Етериум Анализ'
                ]
            ]);
            $ethereum_analyze->save();
        }

        $litecoin_analyze = AnalyzeCategory::whereTranslation('title', 'Litecoin')->first();
        if (empty($litecoin_analyze)) {
            $litecoin_analyze = new AnalyzeCategory();
            $litecoin_analyze->coin_id = Coin::where('symbol', 'ltc')->first()->id;
            $litecoin_analyze->visible = 1;
            $litecoin_analyze->fill([
                'bg' => [
                    'title' => 'Litecoin Анализ',
                    'meta_title' => 'Litecoin Анализ'
                ]
            ]);
            $litecoin_analyze->save();
        }

        $others_analyze = AnalyzeCategory::whereTranslation('title', 'Други')->first();
        if (empty($others_analyze)) {
            $others_analyze = new AnalyzeCategory();
            $others_analyze->visible = 1;
            $others_analyze->fill([
                'bg' => [
                    'title' => 'Други',
                    'meta_title' => 'Други'
                ]
            ]);
            $others_analyze->save();
        }


        $blog_others = BlogCategory::whereTranslation('title', 'Други')->first();
        if (empty($blog_others)) {
            $blog_others = new BlogCategory();
            $blog_others->visible = 1;
            $blog_others->fill([
                'bg' => [
                    'title' => 'Други',
                    'meta_title' => 'Други'
                ]
            ]);
            $blog_others->save();
        }

        $blog_blockchain = BlogCategory::whereTranslation('title', 'Блокчейн')->first();
        if (empty($blog_blockchain)) {
            $blog_blockchain = new BlogCategory();
            $blog_blockchain->visible = 1;
            $blog_blockchain->fill([
                'bg' => [
                    'title' => 'Блокчейн',
                    'meta_title' => 'Блокчейн'
                ]
            ]);
            $blog_blockchain->save();
        }

        $blog_altcoins = BlogCategory::whereTranslation('title', 'Алткойни')->first();
        if (empty($blog_altcoins)) {
            $blog_altcoins = new BlogCategory();
            $blog_altcoins->visible = 1;
            $blog_altcoins->fill([
                'bg' => [
                    'title' => 'Алткойни',
                    'meta_title' => 'Алткойни'
                ]
            ]);
            $blog_altcoins->save();
        }

        $blog_regulations = BlogCategory::whereTranslation('title', 'Регулации')->first();
        if (empty($blog_regulations)) {
            $blog_regulations = new BlogCategory();
            $blog_regulations->visible = 1;
            $blog_regulations->fill([
                'bg' => [
                    'title' => 'Регулации',
                    'meta_title' => 'Регулации'
                ]
            ]);
            $blog_regulations->save();
        }

        $blog_cryptocrimi = BlogCategory::whereTranslation('title', 'Криптокрими')->first();
        if (empty($blog_cryptocrimi)) {
            $blog_cryptocrimi = new BlogCategory();
            $blog_cryptocrimi->visible = 1;
            $blog_cryptocrimi->fill([
                'bg' => [
                    'title' => 'Криптокрими',
                    'meta_title' => 'Криптокрими'
                ]
            ]);
            $blog_cryptocrimi->save();
        }

        $blog_bitcoin = BlogCategory::whereTranslation('title', 'Биткойн')->first();
        if (empty($blog_bitcoin)) {
            $blog_bitcoin = new BlogCategory();
            $blog_bitcoin->visible = 1;
            $blog_bitcoin->fill([
                'bg' => [
                    'title' => 'Биткойн',
                    'meta_title' => 'Биткойн'
                ]
            ]);
            $blog_bitcoin->save();
        }

        $this->info('Getting all of the data...');
        $posts = DB::connection('mysql_old')->table('wp_posts')->where('post_status', '!=', 'trash')->where('post_type', 'post')->orderBy('post_modified')->get();
        $post_meta = DB::connection('mysql_old')->table('wp_postmeta')->where('meta_key', '_thumbnail_id')->get();
        $images = DB::connection('mysql_old')->table('wp_posts')->where('post_type', 'attachment')->get();
        $terms = DB::connection('mysql_old')->table('wp_terms')->pluck('name', 'term_id');
        $terms_relation = DB::connection('mysql_old')->table('wp_term_relationships')->get();

        $this->info('Found ' . $posts->count() . ' posts.');
        $this->info('Starting the migration...');

        foreach ($posts as $post) {
            $this->info($post->ID);
            if ($post->post_title == 'Автоматична Чернова' || $post->post_title == '') {
                continue;
            }

            if (empty($post->post_content)) {
                continue;
            }
            $current_relations = $terms_relation->where('object_id', $post->ID);

            $analyze = false;

            foreach ($current_relations as $relation) {
                if ($terms[$relation->term_taxonomy_id] == 'Анализи') {
                    $analyze = true;
                }
            }

            $content = str_replace('color: #ff9900;', '', $post->post_content);
            $content = str_replace('color: #00ccff;', '', $content);
            $content = str_replace('color: #000000;', '', $content);
            $content = str_replace('color: #ffffff;', '', $content);
            $content = nl2br($content);
            $content = str_replace('&nbsp;', '', $content);
            $content = $stripped = preg_replace('/\s+/', ' ', $content);
            $content = str_replace('<br /> <br />', '<br /><br />', $content);
//            $content = str_replace('<br /><br />', '<br /><br />', $content);
            $content = preg_replace("/<script.*?\/script>/s", "", $content);


            if ($analyze) {
                $model = new Analyze();
                $model->visible = 1;
                $model->fill([
                    'bg' => [
                        'title' => $post->post_title,
                        'meta_title' => $post->post_title,
                        'slug' => urldecode($post->post_name),
                        'description' => $content,
                    ]
                ]);
                $model->created_at = $post->post_modified;

                if (strpos($post->post_title, 'Биткойн анализ') !== false) {
                    $model->category_id = $bitcoin_analyze->id;
                } elseif (strpos($post->post_title, 'Етериум анализ') !== false) {
                    $model->category_id = $ethereum_analyze->id;
                } elseif (strpos($post->post_title, 'Litecoin анализ') !== false) {
                    $model->category_id = $litecoin_analyze->id;
                } else {
                    $model->category_id = $others_analyze->id;

                }
                $model->save();

            } else {
                $model = new Blog();
                $model->visible = 1;
                $model->fill([
                    'bg' => [
                        'title' => $post->post_title,
                        'meta_title' => $post->post_title,
                        'slug' => urldecode($post->post_name),
                        'description' => $content,
                    ]
                ]);
                $model->created_at = $post->post_modified;

                $model->save();
                $model->categories()->detach();
                foreach ($current_relations as $relation) {
                    $category_name = $terms[$relation->term_taxonomy_id];

                    if ($category_name == 'Uncategorized') {
                        $model->categories()->attach($blog_others->id);

                    }

                    if ($category_name == 'Main') {
                        $model->categories()->attach($blog_blockchain->id);
                    }

                    if ($category_name == 'Биткойн') {
                        $model->categories()->attach($blog_bitcoin->id);
                        $model->coin_id = Coin::where('symbol', 'btc')->first()->id;
                        $model->save();
                    }

                    if ($category_name == 'Етериум') {
                        $model->categories()->attach($blog_altcoins->id);
                        $model->coin_id = Coin::where('symbol', 'eth')->first()->id;
                        $model->save();
                    }

                    if ($category_name == 'Алткойн') {
                        $model->categories()->attach($blog_altcoins->id);
                    }

                    if ($category_name == 'Регулации') {
                        $model->categories()->attach($blog_regulations->id);
                    }

                    if ($category_name == 'Scam новини') {
                        $model->categories()->attach($blog_cryptocrimi->id);
                    }

                    if ($category_name == 'Други') {
                        $model->categories()->attach($blog_others->id);
                    }

                    //Uncategorized => Други
                    //main = Блокчейн
                    //Биткойн = алткойни свързани с btc
                    //Етериум = алткойни свързани с етериум
                    //Алткойн = Алткойни
                    //Регулации
                    //Scam новини = Криптокрими
                    //Други
                }
            }

            //->pluck('guid', 'post_parent');
            $model_images = $post_meta->where('post_id', $post->ID);
//            $model_images = $images->where('post_parent', $post->ID);

//                $this->info($model_images);

            foreach ($model_images as $image) {
                $real_image = $images->firstWhere('ID', $image->meta_value);

                $url = $real_image->guid;
                if (strpos($url, 'localhost') !== false) {
                    continue;
                }
                try {
                    $model->addMediaFromUrl($url)->usingFileName($model->id . '-' . uniqid())->usingName($model->id . '-' . uniqid())->toMediaCollection();
                    break;
                } catch (\Exception $exception) {
                    $this->info($exception->getMessage());
                }
            }
//
//            if ($model_images->isNotEmpty()) {
//                $this->info('Transferring images..');
//                foreach ($model_images as $image) {
//                    $url = $image->guid;
//                    if (strpos($url, 'localhost') !== false) {
//                        continue;
//                    }
//                    try {
//                        $model->addMediaFromUrl($url)->usingFileName($model->id . '-' . uniqid())->usingName($model->id . '-' . uniqid())->toMediaCollection();
//                        break;
//                    } catch (\Exception $exception) {
//                        $this->info($exception->getMessage());
//                    }
//                }
//            }
        }

    }
}
