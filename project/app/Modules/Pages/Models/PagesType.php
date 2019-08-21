<?php

namespace App\Modules\Pages\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PagesType extends Model
{
    use SoftDeletes;

    protected $table = 'pages_types';


    protected $fillable = ['title'];

}
