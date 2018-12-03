<?php

namespace App\Http\Controllers;

use App\Sale;
use Illuminate\Http\Request;
use APIReturn;

class SaleController extends Controller
{
    //
    public function insertSale(Request $request){
        $input = $request->only('sale_title','sale_content');
        $validator = \Validator::make($input,[
            'sale_title' => 'required',
            'sale_content' => 'required'
        ],[
            'sale_title.required' => __('缺少sale_title字段'),
            'sale_content.required' => __('缺少sale_content字段')
        ]);

        if($validator->fails()){
            return APIReturn::error('invalid_parameters',$validator->errors()->all(),400);
        }

        try{
            $Sale = Sale::create([
                'sale_title' => $input['sale_title'],
                'sale_content' => $input['sale_content'],
            ]);
        }catch (\Exception $e){
            return APIReturn::error("some_thing_error",__("数据库读写错误"),500);
        }
        return APIReturn::success(['msg' => "insert success"]);

    }


    public function getSale(Request $request){
        try{
            $Sale = Sale::find($request->input('id'));
            return APIReturn::success($Sale);
        }catch (\Exception $e){
            return $e;
            return APIReturn::error("database_error","数据库错误",500);
        }
    }



}
