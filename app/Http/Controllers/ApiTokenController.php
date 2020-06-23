<?php


namespace App\Http\Controllers;

use App\Http\Utils\ResponseUtil;
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
                    $identifier = $request->getHeaderLine('uuid');
                    $oldUser = User::where('identifier',$identifier)->first();
                    if($oldUser != null)
                    {
                        $oldUser->forceDelete();
                    }
                    $user->identifier = $identifier;
                    $user->save();
                }
                $data = json_decode($response->getContent(),true);
                $data['is_guest'] = $user->is_guest;
                $data['name'] = $user->name;
                $data['email'] = $user->email;
                $data['uuid'] = $request->getHeaderLine('uuid');
                return ResponseUtil::handleResponse($data,ResponseUtil::SUCCESS);
            }
        }
        return $response;
    }
}
