<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use Auth;
use APIReturn;
use App\Appoint;
use App\CarInformation;

class AppointController extends Controller
{
    //
    public function Check(Request $request){
        $input = $request->only('appoint_name','appoint_time','appoint_description','appoint_car_id');
        $validator = \Validator::make($input,[
            'appoint_time' => 'required',
            'appoint_description' => 'required',
            'appoint_car_id' => 'required|numeric'
        ],[
            'appoint_time.required' => __('缺少appoint_time字段'),
            'appoint_description.required' => __('缺少appoint_description字段'),
            'appoint_car_id.required' =>  __('缺少appoint_car_id字段'),
            'appoint_car_id.numeric' =>  __('appoint_car_id字段不合法'),
        ]);

        if($validator->fails()){
            return APIReturn::error('invalid_parameters',$validator->errors()->all(),400);
        }

        try{
            $User = JWTAuth::parseToken()->toUser();
            $appoint = Appoint::create([
                'appoint_name' => $User -> name,
                'appoint_time' => $input['appoint_time'],
                'appoint_description' => $input['appoint_description'],
                'appoint_car_id' => $input['appoint_car_id']
            ]);
        }catch (\Exception $e){
            //return $e;
            return APIReturn::error("some_thing_error",__("数据库读写错误"),500);
        }
        return APIReturn::success(['appoint_id' => $appoint->id , 'appoint_car_id' => $appoint->appoint_car_id]);

    }

    public function getAppoint(Request $request){
        try{
            $appoint = Appoint::find($request->input('id'));
            $carinfo = CarInformation::find($appoint->appoint_car_id);
            return APIReturn::success(["appoint"=>$appoint,"carinfo"=>$carinfo]);
        }catch (\Exception $e){
            //return $e;
            return APIReturn::error("database_error","error数据库错误",500);
        }
    }


    public function getAllAppoint(Request $request){
        try{
            $User = JWTAuth::parseToken()->toUser();
            $appoint = Appoint::where('appoint_name',$User -> name)->get();
            return APIReturn::success($appoint);
        }catch (\Exception $e){
            //return $e;
            return APIReturn::error("database_error","error数据库错误",500);
        }
    }


}
