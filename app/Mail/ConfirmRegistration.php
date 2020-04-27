<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConfirmRegistration extends Mailable
{
    use Queueable, SerializesModels;
    public $datauser;
    public $datavalidation;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($datauser, $datavalidation)
    {
        $this->datauser = $datauser;
        $this->datavalidation = $datavalidation;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $user = $this->datauser;
        $validation = $this->datavalidation;

        return $this->from('id.khoerulumam@gmail.com', 'Kelas Bisa')
            ->subject('Konfirmasi Email')
            ->view('mail.confirm_registration', compact('user', 'validation'));
    }
}
