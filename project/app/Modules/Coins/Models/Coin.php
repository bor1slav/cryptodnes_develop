<?php

namespace App\Modules\Coins\Models;

use App\Modules\Analyzes\Models\AnalyzeCategory;
use App\Modules\Blog\Models\Blog;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kalnoy\Nestedset\NodeTrait;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class Coin extends Model implements HasMedia
{
    use Translatable, NodeTrait, SoftDeletes, HasMediaTrait;

    public $translationForeignKey = 'coin_id';

    protected $table = 'coins';

    public $translatedAttributes = [
        'title', 'description', 'meta_title', 'meta_description', 'meta_keywords', 'slug'
    ];

    protected $with = ['translations'];

    protected $fillable = [
        'api_key',
        'symbol',
        'homepage',
        'repos_url',
        'blockchain_sites',
        'social_links',
        'current_price',
        'current_price_euro',
        'current_price_bgn',
        'old_price_24h',
        'old_price_24h_bgn',
        'old_price_24h_euro',
        'market_cap',
        'market_cap_rank',
        'total_volume',
        'high_24h',
        'low_24h',
        'price_change_24h',
        'price_change_percentage_24h',
        'market_cap_change_24h',
        'market_cap_change_percentage_24h',
        'circulating_supply',
        'total_supply',
        'ath',
        'volume_24h',
        'market_cap_24h',
        'ath_change_percentage',
        'price_change_percentage_1h_in_currency',
        'price_change_percentage_24h_in_currency',
        'price_change_percentage_7d_in_currency',
        'price_change_percentage_30d_in_currency',
        'price_change_percentage_1y_in_currency',
        'old_price_24h',
        'buy_link',
        'graph_data',
        'in_menu',
        'visible'
    ];

    protected $casts = [
        'visible' => 'boolean',
        'in_menu' => 'boolean',
        'price_change_percentage' => 'decimal',
        'blockchain_sites' => 'array',
        'repos_url' => 'array',
        'homepage' => 'array',
        'social_links' => 'array',
        'current_price' => 'float',
        'current_price_euro' => 'float',
        'current_price_bgn' => 'float',
        'price_change_percentage_24h_in_currency' => 'float',
        'price_change_percentage_24h' => 'float',
        'volume_24h' => 'float',
        'market_cap_24h' => 'float',
        'old_price_24h' => 'float',
        'ath' => 'float'
    ];

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')
            ->width(25)
            ->height(25)
            ->sharpen(10)
            ->nonOptimized();

        $this->addMediaConversion('small')
            ->width(50)
            ->height(50)
            ->sharpen(10)
            ->nonOptimized();

        $this->addMediaConversion('medium')
            ->width(280)
            ->height(280)
            ->sharpen(10);
    }

    public function scopeInMenu($query) {
        return $query->where($this->table .'.in_menu', 1);
    }

    public function scopeActive($query) {
        return $query->where($this->table . '.visible', 1);
    }

    public function analyze() {
        return $this->hasOne(AnalyzeCategory::class, 'coin_id', 'id')->active();
    }

    public function articles() {
        return $this->hasMany(Blog::class, 'coin_id', 'id')->active()->reversed();
    }

}
