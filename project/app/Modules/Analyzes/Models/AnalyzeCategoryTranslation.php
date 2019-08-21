<?php

namespace App\Modules\Analyzes\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class AnalyzeCategoryTranslation extends Model
{
    use HasSlug;

    protected $table = 'analyzes_categories_translations';

    public $timestamps = false;

    protected $fillable = [
        'title', 'slug', 'description', 'meta_title', 'meta_description', 'meta_keywords'
    ];

    public function getSlugOptions(): SlugOptions {
        return SlugOptions::create()->generateSlugsFrom('title')->saveSlugsTo('slug')->doNotGenerateSlugsOnUpdate();
    }
}
