<?php

namespace App\Http\Utils;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ResponseUtil
{
    const BAD_REQUEST = 400;
    const UNAUTHORIZED = 401;
    const NOT_FOUND = 404;
    const CREATED = 201;
    const SUCCESS = 200;
    const NOT_ALLOWED = 405;

    public static function handleMessageResponse(string $message, int $status)
    {
        return new Response(json_encode(['message'=>$message]),$status);

//        return response()->json_decode(['message'=>$message],$status);
    }

    public static function handleResponse($data, int $status) : Response
    {
        return response()->json($data,$status);
    }

}
