<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;


class ForgotPasswordMail extends Mailable
{
    use Queueable, SerializesModels;


    private string $link;
    private string $email;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $email, string $link)
    {
        $this->email = $email;
        $this->link = $link;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->subject('Установите новый пароль ' . config('app.name'));
        return $this->view('mails.forgot-password')->with(
            [
                'link' => route('auth.reset-password', ['token' => $this->link]) . "?email=$this->email",
                'email' => $this->email,
            ]
        );
    }
}
