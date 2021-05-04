<?php

namespace App\Listeners;

use App\Events\CommentAnswered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMailCommentAnswer;


class SendMailCommentAnswered
{


    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param  CommentAnswered  $event
     * @return void
     */
    public function handle(CommentAnswered $event)
    {
        Mail::send(new SendMailCommentAnswer($event->comment(), $event->reply()));
    }
}
