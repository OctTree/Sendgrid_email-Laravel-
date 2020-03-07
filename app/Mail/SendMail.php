<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $data;

    public function __construct(Array $data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->data['sender'])
            ->subject($this->data['subject'])
            ->withSwiftMessage(function ($message){ //I have add this call back to send info in header,
                // that var for tracking mail, i call it msg_id, so that s the way we add info to headers;
                $headerData = [
                    'unique_args' => [
                        'msg_id' => $this->data['msg_id']
                    ]
                  ];

                $header = json_encode($headerData);
                $message->getHeaders()
                        ->addTextHeader('X-SMTPAPI', $header);
            })
            ->view('emails.sendEmail')
            ->with('data', $this->data);
                // ->view('emails.sendEmail', compact("e_message"))->subject($e_subject);
    }
}
