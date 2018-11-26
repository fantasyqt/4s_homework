<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//
//Route::get('/', function () {
//    return view('welcome');
//});

Route::group(['prefix' => 'API'], function () {
    Route::get('/', function() {
        return "123";
    });
    Route::group(['prefix' => 'User'], function () {
        Route::post('login','UserController@login');
        Route::post('register', 'UserController@register');

        Route::group(['middleware' => 'jwt.auth.mod'], function () {
            Route::get('info', 'UserController@getUserInfo');
            // Method Need Auth
        });
    });


    Route::group(['prefix' => 'CarInfo'],function(){

       Route::group(['middleware' => 'jwt.auth.mod'],function(){
           Route::post('check', 'CarInformationController@check');
           Route::post('carInfo','CarInformationController@getInfo');
       });
    });

    Route::group(['prefix' => 'Appoint'],function(){
        Route::group(['middleware' => 'jwt.auth.mod'],function(){
            Route::post('check', 'AppointController@check');
            Route::post('appointinfo', 'AppointController@getAppoint');
        });
    });

    /**
     * 客服答疑，/API/Question/info?...获取问题，获取文本和答案
     *          /API/Question/insert?...设置/传入新问题，并检测其合法性
     */
    Route::group(['prefix' => 'Question'],function(){
        Route::get('info', 'QuestionController@getQuestion');
        Route::group(['middleware' => ['jwt.auth.mod','AdminCheck']],function(){
            Route::post('insert', 'QuestionController@insert');
        });
    });


});

