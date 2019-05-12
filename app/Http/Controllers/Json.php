<?php
/**
 * Created by PhpStorm.
 * User: gaurang
 * Date: 27/6/18
 * Time: 6:36 PM
 */

namespace App\Transformers;
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Config;

class Json
{
    public static function response($data = null, $message = null)
    {
        return [
            'code' => Config::get('constants.response_code.success'),
            'msg' => $message,
            'data' => $data,
        ];
    }

    public static function error_response($data = null, $message = null)
    {
        return [
            'code' => Config::get('constants.response_code.error'),
            'msg' => $message,
            'data' => $data,
        ];
    }

    public static function not_found_response($data = null, $message = null)
    {
        if($message === null){
            $message = trans('messages.general.data_not_found');
        }

        return [
            'code' => Config::get('constants.response_code.data_not_found'),
            'msg' => $message,
            'data' => $data,
        ];
    }

    public static function config_error_response($data = null)
    {
        return [
            'code' => Config::get('constants.response_code.config_error'),
            'msg' => trans('messages.general.config_error'),
            'data' => $data,
        ];
    }

    public static function file_not_found_response($data = null)
    {
        return [
            'code' => Config::get('constants.response_code.unknown_file'),
            'msg' => trans('messages.general.file_not_found'),
            'data' => $data,
        ];
    }

    public static function unknown_method_response($data = null)
    {
        return [
            'code' => Config::get('constants.response_code.unknown_method'),
            'msg' => trans('messages.general.method_not_exist'),
            'data' => $data,
        ];
    }

    public static function fail_validation_response($data = null)
    {
        return [
            'code' => Config::get('constants.response_code.validation_failed'),
            'msg' => trans('messages.general.validation_failed'),
            'data' => $data,
        ];
    }

    public static function login_expired_response($data = null)
    {
        return [
            'code' => Config::get('constants.response_code.expired_login'),
            'msg' => trans('messages.general.expired_login'),
            'data' => $data,
        ];
    }

    public static function exception_response($data = null, $message = null)
    {
        return [
            'msg' => $message,
            'code' => Config::get('constants.response_code.exception_exit'),
            'data' => $data,
        ];
    }
}
