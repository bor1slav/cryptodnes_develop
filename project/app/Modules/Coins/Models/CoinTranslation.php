<?php

namespace App\Modules\Coins\Models;

use Illuminate\Database\Eloquent\Model;

class CoinTranslation extends Model {

    protected $table = 'coins_translations';

    public $timestamps = false;

    protected $fillable = [
        'title', 'slug', 'description', 'meta_title', 'meta_description', 'meta_keywords'
    ];
}
