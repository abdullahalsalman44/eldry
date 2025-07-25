<?php

namespace App\Helpers;

class ResponseHelper
{
    public static function success($message = 'success', $data = null, $code = 200)
    {
        return response()->json([
            'message' => $message,
            'data' => $data,
            'code' => $code,
        ], $code);
    }

    public static function error($message = 'error',  $code = 500)
    {
        return response()->json([
            'message' => $message,
            'code' => $code,
        ], $code);
    }
}
