<?php

namespace Charlotte\Administration\Models;

use Illuminate\Database\Eloquent\Model;

class SettingTranslation extends Model {

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'field', 'value' , 'locale'
    ];


}
