<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ForgotPassword extends Mailable
{
    use Queueable, SerializesModels;
    protected $datauser;
    protected $token;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($datauser, $token)
    {
        $this->datauser = $datauser;
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $datauser = $this->datauser;
        $token = $this->token;
        return $this->from('id.khoerulumam@gmail.com', 'Kelasbisa')
            ->subject('Konfirmasi Lupa Kata Sandi')
            ->view('mail.forgot_password', compact('datauser', 'token'));
    }
}
