<?php

namespace App\Console\Commands;

use App\Http\Controllers\ApiUserController;
use App\Quote;
use App\User;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class QuotesOfTheDay extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'quotes:day';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send quotes of the day to users';

    private $unregisteredUserIds = null;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        User::whereNotNull('firebase_id')->orderBy('id')->chunk(50, function($users){
            if($users != null) {
                $this->unregisteredUserIds = [];
                foreach ($users as $user) {
                    $ids = $user->sentQuotes()->pluck('quotes.id')->all();
                    if($ids == null) {
                        $ids = [];
                    }
                    $quotes = Quote::whereNotIn('id',$ids)
                        ->inRandomOrder()
                        ->limit(10)
                        ->get();

                    if($quotes != null) {
                        $d = $this->sendDataNotification($user, $quotes);
                        $this->info("Notif sent \n # : {$d[0]}");
                        $user->sentQuotes()->sync($quotes->pluck('id')->all());
                    }
                }
                User::find($this->unregisteredUserIds)->update([
                    'firebase_id' => null
                ]);
                return true;
            }
            else {
                return false;
            }
        });
    }

    private function sendDataNotification(User $user,Collection $quotes)
    {
        $data = [
            "to" => $user->firebase_id,
            "data" =>
                [
                    'quotes' => $quotes,
                ]
        ];

        $dataString = json_encode($data);

        $headers = [
            'Authorization' => ApiUserController::FCM_TOKEN,
            'Content-Type' =>  'application/json'
        ];

        try {
            $http = new Client();
            $response =  $http->request('POST','https://fcm.googleapis.com/fcm/send',[
                'headers' => $headers,
                'body' => $dataString
            ]);
            $data = $response->getBody()->getContents();
            $json = json_decode($data,true);
            $results = null;
            if($json != null) {
                if($json['results'] != null && is_array($json['results'])) {
                    $results = $json['results'];
                    if($results[0] != null && array_key_exists('error',$results[0]) && ($results[0]['error'] == "NotRegistered" || $results[0]['error'] == "InvalidRegistration")) {
                        $this->unregisteredUserIds[] = $user->id;
                    }
                }
            }
            return $data;
        } catch (GuzzleException $exception) {}
    }
}
