<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use Auth;
use APIReturn;
use App\Question;

class QuestionController extends Controller
{
    /**检测新编写的客服问题与答案是否合法
     *
     * @param Request $request
     * @return \缺少字段或数据库有问题会抛异常，否则返回写入的问题编号(id)
     */
    public function insert(Request $request){
        $input = $request->only('question_text','answer');
        $validator = \Validator::make($input,[
            'question_text' => 'required',
            'answer' => 'required'
        ],[
            'question_text.required' => __('缺少question_text字段'),
            'answer.required' => __('缺少answer字段')
        ]);

        if($validator->fails()){
            return APIReturn::error('invalid_parameters',$validator->errors()->all(),400);
        }

        try{
            $question = Question::create([
                'question_text' => $input['question_text'],
                'answer' => $input['answer'],
            ]);
        }catch (\Exception $e){
            return APIReturn::error("some_thing_error",__("数据库读写错误"),500);
        }
        return APIReturn::success(['msg' => "insert success"]);

    }

    /** 通过id获取客服问题
     * @param Request $request
     * @return mixed
     */
    public function getQuestion(Request $request){
        try{
            $question = Question::find($request->input('id'));
            return APIReturn::success($question);
        }catch (\Exception $e){
            return APIReturn::error("database_error","数据库错误",500);
        }
    }
}
