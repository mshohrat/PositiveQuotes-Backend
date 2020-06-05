<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiConfigController extends Controller
{
    //
    public function config(Request $request)
    {
        $user = $request->user();
        return response()->json(['is_user_active'=>$user->is_active,'requires_token'=> $user->firebase_id == null],200);
    }
}
