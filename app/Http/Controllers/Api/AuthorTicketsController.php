<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Filters\TicketFilter;
use App\Http\Requests\Api\ReplaceTicketRequest;
use App\Http\Requests\Api\StoreTicketRequest;
use App\Http\Requests\Api\UpdateTicketRequest;
use App\Http\Resources\Api\TicketResource;
use App\Models\Ticket;
use App\Models\User;
use App\Policies\TicketPolicy;
use App\Traits\apiResponses;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class AuthorTicketsController extends ApiController
{
    use apiResponses;
    protected $policyClass = TicketPolicy::class;
    //
    public function index($author_id, TicketFilter $filters)
    {
        return TicketResource::collection(Ticket::where('user_id', $author_id)->filter($filters)->get());
    }

    // Create resource in the auth contorller
    public function store($author_id, StoreTicketRequest $request)
    {
        // check user
        try {
            // policy
            $this->isAble('store', Ticket::class);

            return new TicketResource(Ticket::create($request->mappedAttributes([
                'author' => "user_id"
            ])));
        } catch (AuthorizationException $ex) {
            return $this->error('You are not authorized to create the ticket', 401);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function replace(ReplaceTicketRequest $request, $author_id, $ticket_id)
    {
        // check user
        try {
            $ticket = Ticket::where('id', $ticket_id)
                ->where('user_id', $author_id)
                ->findOrFail();

            $this->isAble('replace', $ticket);

            $ticket->update($request->mappedAttributes());
            return new TicketResource($ticket);
        } catch (ModelNotFoundException $exception) {
            return $this->error('Ticket cannot be found', 404);
        } catch (AuthorizationException $ex) {
            return $this->error('You are not authorized to replace the ticket', 401);
        }
    }
    /* * Update the specified resource in storage.
     */
    public function update(UpdateTicketRequest $request, $author_id, $ticket_id)
    {
        // check user
        try {
            $ticket = Ticket::where('id', $ticket_id)
                ->where('user_id', $author_id)
                ->findOrFail();

            $this->isAble('update', $ticket);


            $ticket->update($request->mappedAttributes());
            return new TicketResource($ticket);
            
        } catch (ModelNotFoundException $exception) {
            return $this->error('Ticket cannot be found', 404);
        } catch (AuthorizationException $ex) {
            return $this->error('You are not authorized to update the ticket', 401);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($author_id, $ticket_id)
    {
        // delete tickets
        try {
            $ticket = Ticket::where('id', $ticket_id)
                ->where('user_id', $author_id)
                ->findOrFail();

            $this->isAble('replace', $ticket);

            $ticket->delete();
            return $this->ok('Ticket Delete Successfull');

        } catch (ModelNotFoundException $exception) {
            return $this->error('Ticket cannot be found', 404);
        } catch (AuthorizationException $ex) {
            return $this->error('You are not authorized to delete the ticket', 401);
        }
    }
}
