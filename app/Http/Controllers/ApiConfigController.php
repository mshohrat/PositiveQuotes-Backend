<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiConfigController extends Controller
{
    //
    public function config(Request $request)
    {
        return response()->json(['is_user_active'=>$request->user()->is_active],200);
    }
}
