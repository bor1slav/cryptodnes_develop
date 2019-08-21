<?php

namespace App\Modules\Subscribers\Models;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    protected $table = 'visitors';

    protected $fillable = ['ip'];
}
