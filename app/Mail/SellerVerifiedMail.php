<?php

namespace App\Mail;

use App\Models\Seller;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SellerVerifiedMail extends Mailable
{
    use Queueable, SerializesModels;

    public Seller $seller;

    public function __construct(Seller $seller)
    {
        $this->seller = $seller;
    }

    public function build()
    {
        return $this->subject('Your Seller Account Has Been Verified')
            ->view('verify_email');
    }
}
