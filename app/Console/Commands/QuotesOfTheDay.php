<?php

namespace App\Console\Commands;

use App\Http\Controllers\ApiUserController;
use App\SentQuote;
use App\User;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;

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
        //
        $users = DB::table('users')->whereNotNull('firebase_id');
        if($users != null) {
            foreach ($users as $user) {
                $sent_quotes = DB::table('sent_quotes')
                    ->where('sent-quotes.quote_id', 'quotes.id')
                    ->where('sent-quotes.user_id', $user->id)
                    ->pluck('id')->all();
                $quotes = DB::table('quotes')->whereNotIn('id', $sent_quotes)->inRandomOrder()->limit(10)->get();

                if($quotes != null) {

                    $this->sendDataNotification($user->firebase_id, $quotes);

                    $new_sent_quotes = [];
                    foreach ($quotes as $quote)
                    {
                        $new_sent_quotes[] = new SentQuote([
                            'user_id' => $user->id,
                            'quote_id' => $quote->id
                        ]);
                    }
                    DB::table('sent_quotes')->insert($new_sent_quotes);
                }
            }
        }
    }

    private function sendDataNotification(string $token,Collection $quotes)
    {
        $data = [
            "to" => $token,
            "data" =>
                [
                    'quotes' => $quotes,
                ],
        ];

        $dataString = json_encode($data);

        $headers = [
            'Authorization' => ApiUserController::FCM_TOKEN,
            'Content-Type' =>  'application/json'
        ];

        try {
            $http = new Client();
            $http->request('POST','https://fcm.googleapis.com/fcm/send',[
                'headers' => $headers,
                'body' => $dataString
            ]);
        } catch (GuzzleException $exception) {}
    }
}
