<?php

namespace App\Http\Controllers;

use App\Http\Utils\ResponseUtil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use FCM;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;

class ApiConfigController extends Controller
{
    //
    public function config(Request $request)
    {
        $this->sendNotif($request);
        return ResponseUtil::handleResponse(['is_user_active'=>$request->user()->is_active,'requires_token' =>$request->user()->firebase_id == null],ResponseUtil::SUCCESS);
    }

    public function sendNotif(Request $request)
    {
        $users = DB::table('users')->whereNotNull('firebase_id');
        if($users != null) {
            foreach ($users as $user)
            {
                $notificationBuilder = new PayloadNotificationBuilder();
                $notificationBuilder->setTitle('Hi');
                $notificationBuilder->setBody('Perfect!');
                $notification = $notificationBuilder->build();

                $optionBuilder = new OptionsBuilder();
                $optionBuilder->setTimeToLive(60 * 20);
                $option = $optionBuilder->build();

                FCM::sendTo($user->firebase_id, $option, $notification, null);
            }
        }
    }
}
