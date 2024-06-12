<?php

namespace App\Policies;

use App\Models\Ticket;
use App\Models\User;

class TicketPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function update(User $user, Ticket $ticket){
        return $user->id === $ticket->user_id;
    }
    public function authorize(User $user, Ticket $ticket){
        return $user->id === $ticket->user_id;
    }
}
