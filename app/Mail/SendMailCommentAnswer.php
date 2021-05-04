<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMailCommentAnswer extends Mailable
{
    use Queueable, SerializesModels;

    public $comment, $reply;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($comment, $reply)
    {
        $this->comment = $comment;
        $this->reply = $reply;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->to($this->comment->email)
            ->view('mails.comments.answer-comment');
    }
}
