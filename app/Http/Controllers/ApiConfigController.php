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
                    'Authorization: key=AAAAkpnYfto:APA91bFu54tAtMVCVeMJpq2_XhJ6T6vXJRlOamfcYx70bkiBILO58ixJFKILeiuGmeb-6wYTlLlQGi76vBu4iLkAnbcmpns7OZ2AGZYnXD6bX0rY3q8gu6wppk0X79w5n_2j4smJh1Oj',
                    'Content-Type: application/json'
//                    'Content-Length: ' . strlen($dataString),
                ];


                try {
                    $http = new Client();
                    $response = $http->request('POST','https://fcm.googleapis.com/fcm/send',[
                        'headers' => $headers,
                        'body' => $dataString
                    ]);
                } catch (GuzzleException $exception)
                {
//                    return response()->json([
//                        'headers' => $headers,
//                        'body' => $dataString
//                    ]);
                    return response()->json($exception);
                }



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
