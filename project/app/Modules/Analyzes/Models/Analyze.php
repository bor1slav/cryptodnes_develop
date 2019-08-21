<?php

namespace App\Modules\Analyzes\Models;

use App\Modules\Blog\Models\Blog;
use App\Modules\Blog\Models\BlogComment;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kalnoy\Nestedset\NodeTrait;
use Spatie\Feed\Feedable;
use Spatie\Feed\FeedItem;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class Analyze extends Model implements HasMedia, Feedable
{
    use Translatable, NodeTrait, SoftDeletes, HasMediaTrait;

    public $translationForeignKey = 'analyze_id';

    protected $table = 'analyzes';

    public $translatedAttributes = [
        'title', 'description', 'meta_title', 'meta_description', 'meta_keywords', 'slug', 'mini_description', 'picture_description'
    ];

    protected $with = ['translations', 'media'];

    public $timestamps = true;

    protected $fillable = ['visible', 'is_popular', 'category_id', 'views_count', 'next_article_id', 'source', 'created_at'];

    protected $casts = [
        'visible' => 'boolean',
        'is_popular' => 'boolean',
    ];

    public function category()
    {
        return $this->hasOne(AnalyzeCategory::class, 'id', 'category_id');
    }


    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')
            ->width(200)
            ->height(200)
            ->sharpen(10)
            ->nonOptimized();

        $this->addMediaConversion('big')
            ->width(1036)
            ->height(533)
            ->sharpen(10)
            ->nonOptimized();
    }

    public function estimate_reading_time($content)
    {
        $content = strip_tags(htmlspecialchars_decode($content));
        $word_count = str_word_count($content);

        $minutes = floor($word_count / 200);
        $seconds = floor($word_count % 200 / (200 / 60));

        $str_minutes = trans('blog::admin.minutes');
        $str_seconds = trans('blog::admin.seconds');

        if ($minutes == 0) {
            return "1 {$str_minutes}";
        } else {
//            return "{$minutes} {$str_minutes}, {$seconds} {$str_seconds}";
            return "{$minutes} {$str_minutes}";
        }
    }

    public function scopeActive($query) {
        return $query->where($this->table . '.visible', 1);
    }

    public function next()
    {
        return $this->hasOne(Analyze::class, 'id', 'next_article_id')->active();
    }


    public function scopeIsPopular($query)
    {
        return $query->where($this->table . '.is_popular', 1);
    }

    public function comments()
    {
        return $this->hasMany(AnalyzeComment::class, 'article_id', 'id')->active();
    }

    public function toFeedItem()
    {
        if (empty($this->title)) {

        }
        $summary = strip_description($this->mini_description, 197);
        if (empty($this->mini_description)) {
            $summary =   strip_description($this->description, 197);
        }
        return FeedItem::create()
            ->id($this->id)
            ->title($this->title)
            ->summary($summary)
            ->updated($this->updated_at)
            ->id($this->category->slug. '/' . $this->slug)
            ->link(route('analyzes.index', ['category_slug' => $this->category->slug, 'article_slug' => $this->slug]))
            ->author('www.cryptodnes.bg');
    }

    public static function getFeedItems()
    {
        return Analyze::where('analyzes' . '.visible', 1)->whereHas('category')->whereHas('translations')->with('category')->get();
    }
}
