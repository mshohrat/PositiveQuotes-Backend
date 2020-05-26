<?php

use App\Profile;
use App\UserSetting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
        if(\App\User::where('email','admin@nowui.com')->first() == null) {
            DB::table('users')->insert([
                'name' => 'Admin',
                'email' => 'admin@nowui.com',
                'email_verified_at' => now(),
                'password' => Hash::make('secret'),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
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
