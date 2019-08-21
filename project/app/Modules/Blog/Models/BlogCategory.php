<?php

namespace App\Modules\Blog\Models;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kalnoy\Nestedset\NodeTrait;

class BlogCategory extends Model
{
    use Translatable, NodeTrait, SoftDeletes;

    public $translationForeignKey = 'category_id';

    public $translatedAttributes = [
        'title', 'description', 'meta_title', 'meta_description', 'meta_keywords', 'slug'
    ];

    protected $with = ['translations'];

    protected $fillable = ['visible', 'in_menu', 'in_index', 'parent_id'];

    protected $casts = [
        'visible' => 'boolean',
        'in_menu' => 'boolean',
        'in_index' => 'boolean',
    ];

    public function scopeActive($query) {
        return $query->where($this->table . '.visible', 1);
    }

    public function scopeInMenu($query) {
        return $query->where($this->table . '.in_menu', 1);
    }

    public function scopeInIndex($query) {
        return $query->where($this->table . '.in_index', 1);
    }

    public function articles() {
        return $this->belongsToMany(Blog::class, 'blog_categories_relations', 'category_id', 'article_id')->active()->reversed();
    }
}
