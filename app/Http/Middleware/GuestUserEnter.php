<?php

namespace App\Http\Middleware;

use App\Profile;
use App\User;
use App\UserSetting;
use Closure;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class GuestUserEnter
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $request->validate([
            'client_id' => 'required|string',
            'client_secret' => 'required|string',
            'uuid' => 'required|string'
        ]);
        $user = User::where('identifier',$request->uuid)->first();
        if($user != null) {
            return  response()->json(['message' => 'The method specified in the request is not allowed!'], 405);
        }
        $name = 'Guest'.rand(10000001,99999999);
        $password = Str::random(8);
        $user = new User([
            'name' => $name,
            'email' => $name.'@PositiveQuotes2020',
            'password' => Hash::make($password),
            'identifier' => $request->uuid,
            'is_guest' => true
        ]);
        $user->save();
        $this->createProfileAndSetting($user->email);
        $request['grant_type'] = 'password';
        $request['username'] = $user->email;
        $request['password'] = $password;
        $request->headers->add(['uuid'=> $request->uuid]);
        return $next($request);
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
}
