<?php

namespace App\Http\Controllers;

use App\Http\Utils\ResponseUtil;
use App\UserSetting;
use Illuminate\Http\Request;

class ApiSettingController extends Controller
{
    //
    public function edit(Request $request) {
        $request->validate([
            'interval' => 'required|integer',
        ]);
        $interval = -1;
        switch ($request->interval)
        {
            case UserSetting::INTERVAL_DAILY :
            case UserSetting::INTERVAL_12_HOURS :
            case UserSetting::INTERVAL_8_HOURS :
            case UserSetting::INTERVAL_6_HOURS :
            case UserSetting::INTERVAL_4_HOURS :
            case UserSetting::INTERVAL_3_HOURS :
                $interval = $request->interval;
                break;
            default :
                $interval = -1;
                break;
        }
        if($interval == -1) {
            return ResponseUtil::handleMessageResponse("Interval value is invalid",ResponseUtil::BAD_REQUEST);
        }
        else {
            $setting = UserSetting::where('user_id',$request->user()->id)->first();
            $setting->interval = $interval;
            $setting->save();
            return ResponseUtil::handleResponse(['setting'=> $setting],ResponseUtil::SUCCESS);
        }
    }
}
