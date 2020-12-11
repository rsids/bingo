<?php

namespace App\Mail;

use App\Models\Email;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BingoMail extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Email $email, User $user)
    {
        //
        $this->email = $email;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $cards = $this->email->cards->filter(function($val) {
            return $val->user_id == $this->user->id;
        });

        $mail = $this->view('bingo-mail')
            ->to($this->user->email)
            ->with([
                'subject' => $this->email->subject,
                'body' => $this->email->body
            ]);
        $cards->pluck('id')->all()->each(function($id) use ($mail) {
            $mail->attach(sprintf('%s/app/card-%s.pdf', storage_path(), $id));
        });
        return $mail;
    }
}
