<?php

namespace App\Events;

use App\Comment;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class NewComment implements ShouldBroadcastNow
{
  // +++ Implement je dodato
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public $comment;
    // +++ Mora biti public zbog  pusher-a

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Comment $comment)
    {
      $this->comment = $comment;
      // +++ Ukljucen comment da bih uzeo ID kao flag za dalje
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {

        return new Channel('post.'.$this->comment->post->id);
    }

    public function broadcastWith()
    {
      // +++ customize data for pusher
      // PAYLOAD
      return [
        'body' => $this->comment->body,
        'created_at' => $this->comment->created_at->toFormattedDateString(),
        'user' => [
          'name' => $this->comment->user->name,
          'avatar' => 'http://lorempixel.com/50/50'
        ]
      ];
    }
}
