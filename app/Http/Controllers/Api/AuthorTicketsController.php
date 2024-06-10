<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Filters\TicketFilter;
use App\Http\Requests\Api\StoreTicketRequest;
use App\Http\Resources\Api\TicketResource;
use App\Models\Ticket;
use App\Models\User;
use App\Traits\apiResponses;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class AuthorTicketsController extends ApiController
{
    use apiResponses;
    //
    public function index($author_id, TicketFilter $filters)
    {
        return TicketResource::collection(Ticket::where('user_id', $author_id)->filter($filters)->get());
    }

    // Create resource in the auth contorller
    public function store($author_id, StoreTicketRequest $request)
    {
        $model = [
            'title' => $request->input('data.attributes.title'),
            'description' => $request->input('data.attributes.description'),
            'status' => $request->input('data.attributes.status'),
            'user_id' => $author_id,
        ];
        return new  TicketResource(Ticket::create($model));
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($author_id, $ticket_id)
    {
        // delete tickets
        try {
            $ticket = Ticket::findOrFail($ticket_id);

            if ($ticket->user_id == $author_id) {
                $ticket->delete();
                return $this->ok('Ticket Delete Successfull');
            }
            return $this->error('Ticket cannot be found', 404);

        } catch (ModelNotFoundException $exception) {
            return $this->error('Ticket cannot be found', 404);
        }
    }
}
