<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ApiRecoverUserPassword extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    private $to_email;
    private $title;
    private $message;
    public function __construct($to_email = '', $title = '', $message = '')
    {   
        $this->to_email = $to_email;
        $this->title = $title;
        $this->message = $message;
        $this->build();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('agus.jimenez.caba@gmail.com')
                    ->subject( $this->title )
                    ->view('emails.forgot-password', ['message' => $this->message] );
    }
}
