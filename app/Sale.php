<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    //
    protected $fillable = [
        'sale_title','sale_content'
    ];

    protected $hidden = [
        'created_at','updated_at'
    ];
}
