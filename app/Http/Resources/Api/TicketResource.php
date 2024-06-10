<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'type'=>'Ticket',
            'id'=>$this->id,
            'attributes'=>[
                'title'=>$this->title,
                $this->mergeWhen(
                    $request->routeIs('tickets.show'),
                    [
                        'description'=>$this->description,
                        'status'=>$this->status,
                        'createdAt'=>$this->created_at,
                        'updatedAt'=>$this->updated_at,
                    ]
                ),
            ],
            'relationalship'=>[
                'data'=>[
                    'type'=>'User',
                    'id'=>$this->user->id,
                    'name'=>$this->user->name,
                ],
                'links'=>[
                    'salf'=> route('users.show',['user'=>$this->user_id])
                ]
            ],
            'includes'=> new UserResource($this->whenLoaded('user'))

        ];
    }
}
