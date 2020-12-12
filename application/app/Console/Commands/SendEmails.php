<?php

namespace App\Console\Commands;

use App\Mail\BingoMail;
use App\Models\Email;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "mail:send";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Checks for unsent mails";

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
     * @return int
     */
    public function handle()
    {
        Log::info("Executing mail");
        $emails = Email::where("sent", 0)->get();
        $emails->each(function ($email) {
            $users = [];
            Log::info("Sending mail", [$email->subject]);
            $email->cards->each(function ($card) use (&$users) {
                $users[] = $card->user;
                Artisan::call("bingo:card", [
                    "card" => $card->id,
                ]);
            });
            collect($users)
                ->unique("id")
                ->values()
                ->each(function ($user) use ($email) {
                    $cards = $email->cards->filter(function ($val) use ($user) {
                        return $val->user_id == $user->id;
                    });
                    Log::info("Mailing to user", [$user]);
                    Mail::to($user->email)->send(
                        new BingoMail($email, $user, $cards)
                    );
                    $cards->each(function ($card) {
                        $card->sent = 2;
                        $card->save();
                    });
                });
            $email->sent = 2;
            $email->save();
        });

        return 0;
    }
}
