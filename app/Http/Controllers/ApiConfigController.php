<?php

namespace App\Http\Controllers;

use App\Http\Utils\ResponseUtil;
use GuzzleHttp\Client;
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

                //$dataString = json_encode($data);

                $headers = [
                    'Authorization: key=' . env('FCM_SERVER_KEY'),
                    'Content-Type: application/json'
//                    'Content-Length: ' . strlen($dataString),
                ];

                $http = new Client();
                $response = $http->post('https://fcm.googleapis.com/fcm/send',[
                    'headers' => $headers,
                    'form-params' => $data
                ]);

//                $ch = curl_init();
//
//                curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
//                curl_setopt($ch, CURLOPT_POST, true);
//                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//                curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
//
//                $result = curl_exec($ch);
                return response()->json($response);

//                $notificationBuilder = new PayloadNotificationBuilder();
//                $notificationBuilder->setTitle('Hi');
//                $notificationBuilder->setBody('Perfect!');
//                $notification = $notificationBuilder->build();
//
//                $optionBuilder = new OptionsBuilder();
//                $optionBuilder->setTimeToLive(60 * 20);
//                $option = $optionBuilder->build();
//
//                FCM::sendTo($user->firebase_id, $option, $notification, null);
            }
        }
    }
}
