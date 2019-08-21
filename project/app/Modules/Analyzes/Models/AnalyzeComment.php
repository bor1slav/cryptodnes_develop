<?php

namespace App\Modules\Analyzes\Models;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class AnalyzeComment extends Model
{
    use  NodeTrait;


    protected $table = 'analyzes_comments';

    protected $fillable = ['name', 'comment', 'email', 'visible', 'article_id', 'parent_id'];

    protected $casts = ['visible' => 'boolean'];

    public function article()
    {
        return $this->hasOne(Analyze::class, 'id', 'article_id');
    }

    public function scopeActive($query)
    {
        return $query->where($this->table . '.visible', 1);
    }
}
