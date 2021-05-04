<?php

namespace App\Listeners;

use App\Events\PostViewed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\PostView;

class IncrementsPostViewed
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param PostViewed $event
     * @return void
     */
    public function handle(PostViewed $event)
    {
        $postViews = new PostView;
//Paga o id do usuário logado ou pega por default o user 1 caso não logado
        if (auth()->check())
            $postViews->user_id = auth()->user()->id;
        else
            $postViews->user_id = 1;


        $postViews->post_id = $event->post->id;
        $postViews->save();
    }
}
