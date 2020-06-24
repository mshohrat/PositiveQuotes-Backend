<?php

namespace App\Http\Controllers;

use App\Http\Utils\ResponseUtil;
use App\UserSetting;
use Illuminate\Http\Request;

class ApiConfigController extends Controller
{
    //
    public function config(Request $request)
    {
        $setting = UserSetting::where('user_id',$request->user()->id)->first();
        return ResponseUtil::handleResponse(['is_user_active'=>$request->user()->is_active,'requires_token' =>$request->user()->firebase_id == null, 'setting' => $setting],ResponseUtil::SUCCESS);
    }
}
