<?php

namespace App\Modules\Pages\Models;

use Dimsav\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kalnoy\Nestedset\NodeTrait;

class Page extends Model
{
    use Translatable, NodeTrait, SoftDeletes;

    public $translationForeignKey = 'page_id';

    protected $table = 'pages';

    public $translatedAttributes = [
        'title', 'description', 'meta_title', 'meta_description', 'meta_keywords', 'slug'
    ];

    protected $with = ['translations'];

    protected $fillable = ['visible', 'type_id'];

    protected $casts = ['visible' => 'boolean'];

    public function scopeActive($query) {
        return $query->where($this->table . '.visible', 1);
    }

    public function types()
    {
        return $this->hasOne(PagesType::class, 'id', 'type_id');
    }
}
