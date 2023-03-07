<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class emailTemplate extends Mailable
{
    use Queueable, SerializesModels;

    public $name ;
    public $url ;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name , $url)
    {
        //
        $this->name = $name ;
        $this->url = $url ;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            from : new Address('festivmedia@info.com', 'Festiv Media'),
            subject: 'Film Submission',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            // view: 'email.EmailTemplateView',
            // to use laravel email template, we use 'markdown' instead of 'view'
            markdown: 'email.EmailTemplateView',
            with : [
                'name' => $this->name ,
                'url' => $this->url ,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
