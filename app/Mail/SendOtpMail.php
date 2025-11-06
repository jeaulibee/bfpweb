<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendOtpMail extends Mailable
{
    use Queueable, SerializesModels;

    public $otp;
    public $logoCid; // 👈 used for embedding image

    /**
     * Create a new message instance.
     */
    public function __construct($otp)
    {
        $this->otp = $otp;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        // ✅ Embed the BFP logo from public/images/bfp.jpg
        $this->withSwiftMessage(function ($message) {
            $this->logoCid = $message->embed(public_path('images/bfp.jpg'));
        });

        // ✅ Return the fully built email
        return $this->subject('🔐 Your BFP OTP Verification Code')
                    ->from('no-reply@bfp-smartfire.com', 'Koronadal BFP System')
                    ->view('emails.otp')
                    ->with([
                        'otp' => $this->otp,
                        'logoCid' => $this->logoCid, // pass to Blade
                    ]);
    }
}
