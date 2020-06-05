<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiConfigController extends Controller
{
    //
    public function config(Request $request)
    {
        $user = $request->user();
        $requires_token = 'false';
//        if($user->firebase_id == null)
//        {
//            $requires_token = true;
//        }
        return response()->json(['is_user_active'=>$user->is_active,'requires_token'=> 'false'],200);
    }
}
