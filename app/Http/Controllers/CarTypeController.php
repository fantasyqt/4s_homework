<?php

namespace App\Http\Controllers;

use App\CarType;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use JWTAuth;
use Auth;
use APIReturn;

class CarTypeController extends Controller
{
    /** 全部车型推送的数据，包括标题和简述
     * @param Request $request
     * @return mixed
     */
    public function getAll(Request $request){
        try{
            $question =DB::table('cartypes')->get();
            return APIReturn::success($question);
        }catch (\Exception $e){
            return APIReturn::error("database_error","数据库错误",500);
        }
    }
}
