<?php

namespace App\Modules\Blog\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class BlogTranslation extends Model
{
    use HasSlug;

    protected $table = 'blog_translations';

    public $timestamps = false;

    protected $fillable = [
        'title', 'description', 'meta_title', 'meta_description', 'meta_keywords', 'slug', 'mini_description', 'picture_description'
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()->generateSlugsFrom('title')->saveSlugsTo('slug')->doNotGenerateSlugsOnUpdate();
    }
}
