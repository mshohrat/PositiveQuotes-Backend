<?php


namespace App\Http\Controllers;

use App\User;
use Laravel\Passport\Http\Controllers\AccessTokenController;
use Psr\Http\Message\ServerRequestInterface;

class ApiTokenController extends AccessTokenController
{

    public function issueToken(ServerRequestInterface $request)
    {
        $response =  parent::issueToken($request);
        if($response->isSuccessful())
        {
            $requestParameters = (array) $request->getParsedBody();

            $user = User::where('email',$requestParameters['username'])->first();
            if($user != null) {
                if(!$user->is_guest) {
                    $user->identifier = $request->getHeaderLine('uuid');
                    $user->save();
                }
                $data = json_decode($response->getContent(),true);
                $data['is_guest'] = $user->is_guest;
                $data['name'] = $user->name;
                return response()->json($data,200);
            }
        }
        return $response;
    }
}
