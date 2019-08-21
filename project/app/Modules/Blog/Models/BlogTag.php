<?php

namespace App\Modules\Blog\Models;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kalnoy\Nestedset\NodeTrait;

class BlogTag extends Model
{
    use Translatable, NodeTrait, SoftDeletes;

    public $translationForeignKey = 'tag_id';

    protected $table = 'blog_tags';

    public $translatedAttributes = [
        'title', 'meta_title', 'meta_description', 'meta_keywords', 'slug'
    ];

    protected $with = ['translations'];

    protected $fillable = ['visible', 'in_index'];

    protected $casts = [
        'visible' => 'boolean'
    ];

    public function scopeInIndex($query)
    {
        return $query->where($this->table . '.in_index', 1);
    }

    public function tags()
    {
        return $this->belongsToMany(Blog::class, 'blog_joined_tags', 'tag_id', 'article_id');
    }

    public function scopeActive($query)
    {
        return $query->where($this->table . '.visible', 1);
    }
}
