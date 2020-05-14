<?php

namespace App\Http\Controllers;

use App\Role\UserRole;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\Client;
use Laravel\Passport\Token;
use Lcobucci\JWT\Parser;

class AuthController extends Controller
{
    public function signup(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string',
            'uuid' => 'required|string'
        ]);
        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'identifier' => $request->uuid,
            'is_guest' => false,
        ]);
        $user->setRoles([UserRole::ROLE_CUSTOMER]);
//        $client = $this->getClient($request);
//        if($client->passwordClient == true)
//        {
//            $user->setRoles([UserRole::ROLE_CUSTOMER]);
//        }
//        else if ($client->personalAccessClient)
//        {
//            $user->setRoles([UserRole::ROLE_ADMIN]);
//        }
//        else
//        {
//            return  response()->json(['message' => 'action is not allowed for this client!'], 405);
//        }
        $user->save();
        return response()->json([
            'message' => 'Successfully created user!'
        ], 201);
    }

    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    private function getClient(Request $request) : Client{
        $bearerToken = $request->bearerToken();
        $tokenId = (new Parser())->parse($bearerToken)->getClaim('jti');
        $client = Token::find($tokenId)->client;
        return $client;
    }
}
