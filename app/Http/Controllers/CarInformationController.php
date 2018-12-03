<?php

namespace App\Http\Controllers;

use Egulias\EmailValidator\Exception\ExpectingCTEXT;
use Illuminate\Http\Request;
use JWTAuth;
use Auth;
use APIReturn;
use App\CarInformation;
class CarInformationController extends Controller
{

    /*
     * check Car Information and add data to database
     *
     * @return APIReturn
     * */
    public function check(Request $request)
    {
        $wrong = $request->only('youliang','shuiliang','shuiwen','qidong','wending','xiangsheng','zhuanxiang','shache','lihe','biansuxiang','chedeng');
        $fault_info = json_encode($wrong);
        $input = $request->only('type','mileage','use_time');
        $input['fault_info'] = $fault_info;
        $validator = \Validator::make($input, [
            'type' => 'required',
            'mileage' => 'required|numeric',
            'use_time' => 'required|numeric',
            'fault_info' => 'required',
        ], [
            'type.required' => __('缺少 type 字段'),
            'mileage.required' => __('缺少mileage字段'),
            'mileage.numeric' => __('mileage字段不合法'),
            'use_time.required' => __('缺少use_time字段'),
            'use_time.numeric' => __('use_time字段不合法'),
            'fault_info.required' => __('缺少fault_info字段'),
        ]);

        if ($validator->fails()) {
            return APIReturn::error('invalid_parameters', $validator->errors()->all(), 400);
        }

        try{
            $info = CarInformation::create([
                'type' => $input['type'],
                'mileage' => (double)$input['mileage'],
                'use_time' => (double)$input['use_time'],
                'fault_info' => $input['fault_info'],
            ]);
        }catch (\Exception $e){
            return APIReturn::error("some_thing_error", __("数据库读写错误"), 500);
        }
        return APIReturn::success(['info_id' => $info->id]);
    }

    public function getInfo(Request $request)
    {
        try{
            $info = CarInformation::find($request->input('id'));
            return APIReturn::success($info);
        }catch (\Exception $e){
            return APIReturn::error("database_error", "数据库读写错误", 500);
        }
    }
}
