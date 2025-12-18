<?php
namespace App\Domain\Helpers;

class Response
{
    public static function success($code, $message, $data = null)
    {
        return response()->json([
            'success' => true,
            'code'    => $code,
            'message' => $message,
            'data'    => $data,
            'error'   => null,
        ]);
    }

    public static function error($code, $message, $error = null)
    {
        return response()->json([
            'success' => false,
            'code'    => $code,
            'message' => $message,
            'data'    => null,
            'error'   => $error,
        ]);
    }
}