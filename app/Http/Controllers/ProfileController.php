<?php

namespace App\Http\Controllers;

use App\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    //
    public function get(Request $request)
    {
        $profile = Profile::where('user_id',$request->user()->id)->first();
        if($profile != null)
        {
            return response()->json($profile, 200);
        }
        return response()->json(['message' => 'Profile not found!'], 404);
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
            return response()->json($profile, 200);
        }
        return response()->json(['message' => 'Profile not found!'], 404);
    }
}
