<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConfirmTransaction extends Mailable
{
    use Queueable, SerializesModels;
    public $datauser;
    public $dataclass;
    public $prices;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($datauser, $dataclass, $prices)
    {
        $this->datauser = $datauser;
        $this->dataclass = $dataclass;
        $this->prices = $prices;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $datauser = $this->datauser;
        $dataclass = $this->dataclass;
        $prices = $this->prices;
        return $this->from('id.khoerulumam@gmail.com', 'Kelas Bisa')
            ->subject('Konfirmasi Pembelian Kelas')
            ->view('mail.confirm_transaction', compact('datauser', 'dataclass', 'prices'));
    }
}
