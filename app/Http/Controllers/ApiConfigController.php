<?php

namespace App\Http\Controllers;

use App\Http\Utils\ResponseUtil;
use Illuminate\Http\Request;

class ApiConfigController extends Controller
{
    //
    public function config(Request $request)
    {
        return ResponseUtil::handleResponse(['is_user_active'=>$request->user()->is_active,'requires_token' =>$request->user()->firebase_id == null],ResponseUtil::SUCCESS);
    }
}
