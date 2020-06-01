<?php

namespace App\Http\Utils;

use Illuminate\Http\Response;

class ResponseUtil
{
    const BAD_REQUEST = 400;
    const UNAUTHORIZED = 401;
    const NOT_FOUND = 404;
    const CREATED = 201;
    const SUCCESS = 200;
    const NOT_ALLOWED = 405;

    public static function handleErrorResponse(string $message, int $status) : Response
    {
        return response()->json(['message'=>$message],$status);
    }

    public static function handleResponse($data, int $status) : Response
    {
        return response()->json($data,$status);
    }

}
