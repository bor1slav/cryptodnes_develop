<?php

namespace App\Modules\Blog\Models;

use App\Modules\Coins\Models\Coin;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kalnoy\Nestedset\NodeTrait;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class Blog extends Model implements HasMedia, Feedable
{
    use Translatable, NodeTrait, SoftDeletes, HasMediaTrait;

    public $translationForeignKey = 'article_id';

    protected $table = 'blog';

    public $translatedAttributes = [
        'title', 'description', 'meta_title', 'meta_description', 'meta_keywords', 'slug', 'mini_description', 'picture_description'
    ];

    public $timestamps = true;

    protected $with = ['translations', 'media'];

    protected $fillable = ['visible', 'is_popular', 'in_index', 'category_id', 'views_count', 'next_article_id', 'coin_id', 'source' , 'created_at', 'main'];

    protected $casts = [
        'main' => 'boolean',
        'visible' => 'boolean',
        'is_popular' => 'boolean',
        'in_index' => 'boolean',
    ];

    public function estimate_reading_time($content)
    {
        $content = strip_tags(htmlspecialchars_decode($content));
        $content = trim(preg_replace('/\s\s+/', ' ', $content));
        $word_count = count(preg_split('/\s+/', $content));
        $minutes = floor($word_count / 200);
        $seconds = floor($word_count % 200 / (200 / 60));

        $str_minutes = trans('blog::admin.minutes');
        $str_seconds = trans('blog::admin.seconds');

        if ($minutes == 0) {
            return "1 {$str_minutes}";
        } else {
//            return "{$minutes} {$str_minutes}, {$seconds} {$str_seconds}";
            if ($seconds > 30) {
                $minutes++;
            }
            return "{$minutes} {$str_minutes}";
        }
    }

    public function scopeIsPopular($query)
    {
        return $query->where($this->table . '.is_popular', 1);
    }

    public function scopeIsMain($query)
    {
        return $query->where($this->table . '.main', 1);
    }

    public function scopeInIndex($query)
    {
        return $query->where($this->table . '.in_index', 1);
    }

    public function scopeActive($query)
    {
        return $query->where($this->table . '.visible', 1)->whereHas('categories')->whereHas('translations');
    }


    public function categories()
    {
        return $this->belongsToMany(BlogCategory::class, 'blog_categories_relations', 'article_id', 'category_id');
    }

    public function next()
    {
        return $this->hasOne(Blog::class, 'id', 'next_article_id')->active();
    }

    public function similar_articles()
    {
        return $this->belongsToMany(Blog::class, 'similar_articles', 'article_id', 'similar_article_id');
    }

    public function comments()
    {
        return $this->hasMany(BlogComment::class, 'article_id', 'id')->active();
    }

    public function tags()
    {
        return $this->belongsToMany(BlogTag::class, 'blog_joined_tags', 'article_id', 'tag_id');
    }

    public function coin()
    {
        return $this->hasOne(Coin::class, 'id', 'coin_id');
    }

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')
            ->width(238)
            ->height(168)
            ->sharpen(10)
            ->nonOptimized();

        $this->addMediaConversion('big')
            ->width(1036)
            ->height(533)
            ->sharpen(10)
            ->nonOptimized();

        $this->addMediaConversion('index')
            ->width(1224)
            ->height(706)
            ->sharpen(10)
            ->nonOptimized();
    }

    public function toFeedItem()
    {
        $summary = strip_description($this->mini_description, 197);
        if (empty($this->mini_description)) {
            $summary =   strip_description($this->description, 197);
        }
        return FeedItem::create()
            ->id($this->id)
            ->title($this->title)
            ->summary($summary)
            ->updated($this->updated_at)
            ->id($this->slug)
            ->link(route('blog.view', $this->slug))
            ->author('www.cryptodnes.bg');
    }

    public static function getFeedItems()
    {
        return Blog::where('blog' . '.visible', 1)
                    ->whereHas('categories')
                    ->whereHas('translations')
                    ->orderBy('id','DESC')
                    ->limit(config('web.rss_limit'))
                    ->get();
    }
}
