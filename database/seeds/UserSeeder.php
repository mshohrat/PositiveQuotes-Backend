<?php

use App\Profile;
use App\UserSetting;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        factory(\App\User::class,50)->create()->each(function ($user){
            //if ($user != null) {
                $setting = new UserSetting([
                    'user_id' => $user->id
                ]);
                $setting->save();

                $profile = new Profile([
                    'name' => $user->name,
                    'email' => $user->email,
                    'user_id' => $user->id,
                    'gender' => random_int(0,2)
                ]);
                $profile->save();
            //}
        });
    }
}
