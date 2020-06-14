<?php

namespace App\Http\Controllers;

use App\Http\Utils\ResponseUtil;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;

class ApiConfigController extends Controller
{
    //
    public function config(Request $request)
    {
        return $this->sendNotif($request);
        //return ResponseUtil::handleResponse(['is_user_active'=>$request->user()->is_active,'requires_token' =>$request->user()->firebase_id == null],ResponseUtil::SUCCESS);
    }

    public function sendNotif(Request $request)
    {
        $users = DB::table('users')->whereNotNull('firebase_id')->get();
        if($users != null) {
            foreach ($users as $user)
            {

                $data = [
                    "to" => $user->firebase_id,
                    "notification" =>
                        [
                            'title' => 'Hi',
                            'body' => 'Test Notification'
                        ],
                ];

                $dataString = json_encode($data);

                $headers = [
                    'Authorization' => ApiUserController::FCM_TOKEN,
                    'Content-Type' =>  'application/json'
                ];


                try {
                    $http = new Client();
                    $response = $http->request('POST','https://fcm.googleapis.com/fcm/send',[
                        'headers' => $headers,
                        'body' => $dataString
                    ]);
                } catch (GuzzleException $exception)
               {

                }

                return $response;
            }
        }
    }
}
