<?php
/**
 * Created by PhpStorm.
 * User: fantasyqt
 * Date: 18-11-14
 * Time: 上午7:12
 */

namespace App\Services;


class APIReturnService
{
    public function  APIReturn($status, $data, $httpCode, $redirect = null)
    {
        $body = [
            "status" => $status,
            "data" => $data
        ];
        if ($redirect) {
            $body["redirect"] = $redirect;
        }
        return response()->json($body, $httpCode);
    }
    public function success($data = [], $redirect = null)
    {
        return $this->APIReturn('success', $data, 200, $redirect);
    }

    public function error($code, $message, $httpCode = 500, $redirect = null)
    {
        return $this->APIReturn('fail', [
            'error' => [
                "code" => $code,
                "message" => $message
            ]
        ], $httpCode, $redirect);
    }



}