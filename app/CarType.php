<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
/**车型推送的model*/
class CarType extends Model
{
    /**标题和简介*/
    protected $fillable = [
        'title','introduce'
    ];
    protected $hidden = [
        'created_at','updated_at'
    ];
}
