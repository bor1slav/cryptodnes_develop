<?php

namespace App\Modules\Blog\Models;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class BlogComment extends Model
{
    use  NodeTrait;


    protected $table = 'blog_comments';

    protected $fillable = ['name', 'comment', 'email', 'visible', 'article_id', 'parent_id'];

    protected $casts = ['visible' => 'boolean'];

    public function article() {
        return $this->hasOne(Blog::class, 'id', 'article_id');
    }

    public function scopeActive($query)
    {
        return $query->where($this->table . '.visible', 1);
    }
}
