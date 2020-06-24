<?php

namespace App\Http\Controllers;

use App\Http\Utils\ResponseUtil;
use App\Profile;
use App\Role\UserRole;
use App\User;
use App\UserSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ApiUserController extends Controller
{

    const FCM_TOKEN = 'key=AAAAkpnYfto:APA91bFu54tAtMVCVeMJpq2_XhJ6T6vXJRlOamfcYx70bkiBILO58ixJFKILeiuGmeb-6wYTlLlQGi76vBu4iLkAnbcmpns7OZ2AGZYnXD6bX0rY3q8gu6wppk0X79w5n_2j4smJh1Oj';

    public function signup(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string',
            'uuid' => 'required|string'
        ]);
        $otherUser = User::where('identifier',$request->uuid)->first();
        if($otherUser != null)
        {
            return ResponseUtil::handleMessageResponse('You need to use different identifier ID!',ResponseUtil::BAD_REQUEST);
        }
        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'identifier' => $request->uuid,
            'is_guest' => false,
        ]);
        $user->setRoles([UserRole::ROLE_CUSTOMER]);
        $user->save();
        $this->createProfileAndSetting($user->email);
        return ResponseUtil::handleMessageResponse('Successfully created user!',ResponseUtil::CREATED);
    }

    private function createProfileAndSetting(string $email)
    {
        $user = User::where('email', $email)->first();
        if ($user != null) {
            $setting = new UserSetting([
                'user_id' => $user->id
            ]);
            $setting->save();

            $profile = new Profile([
                'name' => $user->name,
                'email' => $user->email,
                'user_id' => $user->id,
            ]);
            $profile->save();
        }
    }

    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    public function logout(Request $request)
    {
        if(!$request -> expectsJson()) {
            Auth::logout();
            return view('auth.login');
        }
    }

    public function registerFbToken(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
        ]);
        $user = $request->user();
        $user->firebase_id = $request->token;
        $user->save();
        return ResponseUtil::handleMessageResponse('Successfully updated firebase token',ResponseUtil::SUCCESS);
    }

    public function signupFromGuest(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:8',
        ]);
        $user = $request->user();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->is_guest = false;
        $user->setRoles([UserRole::ROLE_CUSTOMER]);
        $user->save();

        return ResponseUtil::handleResponse(['user'=>$user],ResponseUtil::CREATED);
    }
}
