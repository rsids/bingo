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
    public $cards;
    public $user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Email $email, User $user, $cards)
    {
        //
        $this->email = $email;
        $this->cards = $cards;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $mail = $this->view("bingo-mail")
            ->from("contact@idsklijnsma.nl")
            ->with([
                "subject" => $this->email->subject,
                "body" => $this->email->body,
            ]);
        $this->cards->pluck("id")->each(function ($id) use ($mail) {
            $mail->attach(sprintf("%s/app/card-%s.pdf", storage_path(), $id));
        });
        return $mail;
    }
}
