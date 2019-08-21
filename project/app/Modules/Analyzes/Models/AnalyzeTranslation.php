<?php

namespace App\Modules\Analyzes\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class AnalyzeTranslation extends Model
{
    use HasSlug;

    protected $table = 'analyzes_translations';

    public $timestamps = false;

    protected $fillable = [
        'title', 'slug', 'description', 'meta_title', 'meta_description', 'meta_keywords', 'mini_description', 'picture_description'
    ];

    public function getSlugOptions(): SlugOptions {
        return SlugOptions::create()->generateSlugsFrom('title')->saveSlugsTo('slug')->doNotGenerateSlugsOnUpdate();
    }
}
