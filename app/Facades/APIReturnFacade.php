<?php
/**
 * Created by PhpStorm.
 * User: fantasyqt
 * Date: 18-11-14
 * Time: 上午7:17
 */

namespace App\Facades;

use Illuminate\Support\Facades\Facade;
class APIReturnFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return "APIReturnService";
    }
}