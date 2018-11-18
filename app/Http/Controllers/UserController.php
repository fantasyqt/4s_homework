<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\Guard;
use App\User;
use APIReturn;
use JWTAuth;
use Auth;
use Mockery\Exception;
use Tymon\JWTAuth\Exceptions\JWTException;
class UserController extends Controller
{
    //
    private  $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /*
     * User Login function
     * @return APIReturn
     * */

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $validator = \Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required|size:64'
        ], [
            'email.required' => __('缺少 Email 字段'),
            'email.email' => __('Email 字段不合法'),
            'password.required' => __('缺少密码字段'),
            'password.size' => __('密码字段不合法')
        ]);

        if ($validator->fails()) {
            return APIReturn::error('invalid_parameters', $validator->errors()->all(), 400);
        }

        $access_token = null;
        try {
            if (Auth::once($credentials)) {
                $user = Auth::getUser();
            } else {
                return APIReturn::error("invalid_email_or_password", __("Email 与密码不匹配"), 401);
            }
            if (!$user) {
                return APIReturn::error("invalid_email_or_password", __("Email 与密码不匹配"), 401);
            } else {
                $access_token = JWTAuth::fromUser($user//, [
//                    'role' => $user->role]
                );
            }
        } catch (\Exception  $e) {
            return APIReturn::error("database_error", "数据库读写错误", 500);
        }
        return APIReturn::success(['access_token' => $access_token]);


    }
    /*
     * User register
     * @params Request
     * @return APIReturn
     *  */
    public function  register(Request $request)
    {
        $input = $request->only( 'name','email', 'password','address','phone');
        $validator = \Validator::make($input, [
            'name' => 'required|max:30',
            'email' => 'required|email|max:32',
            'password' => 'required|size:64',
            'address' => 'required',
            'phone' => 'required|size:11'
        ], [
            'name.required' => __('缺少用户名字段'),
            'name.max' => __('用户名过长'),
            'email.require' => __('缺少 Email 字段'),
            'email.email' => __('Email 字段不合法'),
            'email.max' => __('Email 过长'),
            'password.required' => __('缺少密码字段'),
            'password.size' => __('密码字段不合法'),
            'address.required' => __('缺少地址字段'),
            'phone.required' => __('缺少手机字段'),
            'phone.size' => __('手机不合法'),
        ]);

        if ($validator->fails()) {
            return APIReturn::error('invalid_parameters', $validator->errors()->all(), 400);
        }

        try {
            $team = User::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'password' => bcrypt($input['password']),
                'phone' => $input['phone'],
                'address' => $input['address'],
                'role' => 'customer'
            ]);
        } catch (\Exception $err) {
            return APIReturn::error("email_or_name_already_exist", __("Email或用户已经存在"), 500);
        }
        return APIReturn::success([
            'msg' => 'Welcome to 4s car',
        ]);
    }
    /*
     * User get info
     * @params Request
     * @return APIReturn
     * */

    public function  getUserInfo(Request $request)
    {
        return APIReturn::success(JWTAuth::parseToken()->toUser());
    }

}
