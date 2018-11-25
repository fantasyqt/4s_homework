<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appoint extends Model
{
    //
    protected $fillable = [
        'appoint_name','appoint_time','appoint_description','appoint_car_id'
    ];

}
