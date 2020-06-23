<?php

namespace App\Http\Controllers;

use App\Http\Utils\ResponseUtil;
use App\Profile;
use App\Role\UserRole;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ApiProfileController extends Controller
{
    public function get(Request $request)
    {
        $profile = Profile::where('user_id',$request->user()->id)->first();
        if($request->expectsJson()) {
            if ($profile != null) {
                return ResponseUtil::handleResponse($profile,ResponseUtil::SUCCESS);
            }
            return ResponseUtil::handleMessageResponse('Profile not found!',ResponseUtil::NOT_FOUND);
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
                return ResponseUtil::handleMessageResponse('User ID is required!',ResponseUtil::BAD_REQUEST);
            }
            if ($profile != null) {
                return ResponseUtil::handleResponse($profile,ResponseUtil::SUCCESS);
            }
            return ResponseUtil::handleMessageResponse('Profile not found!',ResponseUtil::NOT_FOUND);
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
            $user = $request->user();
            $user->name = $request->name;
            $user->save();
            return ResponseUtil::handleResponse($profile,ResponseUtil::SUCCESS);
        }
        return ResponseUtil::handleMessageResponse('Profile not found!',ResponseUtil::NOT_FOUND);
    }
}
