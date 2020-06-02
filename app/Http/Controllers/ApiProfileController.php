<?php

namespace App\Http\Controllers;

use App\Http\Utils\ResponseUtil;
use App\Profile;
use Illuminate\Http\Request;

class ApiProfileController extends Controller
{
    public function get(Request $request)
    {
        $profile = Profile::where('user_id',$request->user()->id)->first();
        if($request->expectsJson()) {
            if ($profile != null) {
                return ResponseUtil::handleResponse($profile,ResponseUtil::SUCCESS);
            }
            return ResponseUtil::handleErrorResponse('Profile not found!',ResponseUtil::NOT_FOUND);
        }
        else
        {
            return view('profile',['profile'=>$profile]);
        }
    }

    public function getById(Request $request)
    {
        $profile = null;
        $id = $request->route('id');
        if($id != null)
        {
            $profile = Profile::where('user_id',$id)->first();
        }
        if($request->expectsJson()) {
            if($id == null)
            {
                return ResponseUtil::handleErrorResponse('User ID is required!',ResponseUtil::BAD_REQUEST);
            }
            if ($profile != null) {
                return ResponseUtil::handleResponse($profile,ResponseUtil::SUCCESS);
            }
            return ResponseUtil::handleErrorResponse('Profile not found!',ResponseUtil::NOT_FOUND);
        }
        else
        {
            return view('profile',['profile'=>$profile]);
        }
    }

    public function edit(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'gender' => 'nullable|integer',
        ]);
        $profile = Profile::where('user_id',$request->user()->id)->first();
        if($profile != null)
        {
            $profile->name = $request->name;
            if($request->has('gender'))
            {
                $profile->gender = $request->gender;
            }
            $profile->save();
            return ResponseUtil::handleResponse($profile,ResponseUtil::SUCCESS);
        }
        return ResponseUtil::handleErrorResponse('Profile not found!',ResponseUtil::NOT_FOUND);
    }
}