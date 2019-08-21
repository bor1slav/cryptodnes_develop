<?php

namespace App\Modules\Analyzes\Models;

use App\Modules\Coins\Models\Coin;
use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kalnoy\Nestedset\NodeTrait;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class AnalyzeCategory extends Model
{
    use Translatable, NodeTrait, SoftDeletes, HasMediaTrait;

    public $translationForeignKey = 'category_id';

    protected $table = 'analyzes_categories';

    public $translatedAttributes = [
        'title', 'description', 'meta_title', 'meta_description', 'meta_keywords', 'slug'
    ];

    protected $with = ['translations'];

    protected $fillable = ['visible', 'coin_id'];

    protected $casts = ['visible' => 'boolean'];

    public function coin()
    {
        return $this->hasOne(Coin::class, 'id', 'coin_id');
    }

    public function articles() {
        return $this->hasMany(Analyze::class, 'category_id', 'id')->active()->reversed()->active();
    }

    public function latestArticle()
    {
        return $this->hasOne(Analyze::class, 'category_id', 'id')->active()->latest();
    }

    public function scopeActive($query) {
        return $query->where($this->table . '.visible', 1);
    }
}
