<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'question_text','answer'
    ];

    protected $hidden = [
        'created_at','updated_at'
    ];
}
