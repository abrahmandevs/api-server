<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type'=>'User',
            'id'=>$this->id,
            'attributes'=>[
                'name'=>$this->name,
                'email'=>$this->email,
                $this->mergeWhen($request->routeIs('users.*'),[
                    'emailVerifiedyAt'=>$this->email_verified_at,
                    'createdAt'=>$this->created_at,
                    'updatedAt'=>$this->updated_at,
                ]),
            ],
            'includes'=> TicketResource::collection($this->whenLoaded('tickets')),
            'links'=>[
                'salf'=> route('users.show',['user'=>$this->id])
            ]
        ];
    }
}
