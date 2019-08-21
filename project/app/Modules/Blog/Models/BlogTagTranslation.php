<?php

namespace App\Modules\Blog\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class BlogTagTranslation extends Model
{
    use HasSlug;

    protected $table = 'blog_tags_translations';

    public $timestamps = false;

    protected $fillable = [
        'title', 'slug', 'meta_title', 'meta_description', 'meta_keywords'

    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()->generateSlugsFrom('title')->saveSlugsTo('slug');
    }
}
