<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarInformation extends Model
{
    protected $fillable = [
        'type','mileage','use_time','fault_info'
    ];
}
