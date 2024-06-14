<?php

namespace App\Http\Requests\Api;

use App\Permissions\Abilities;
use Illuminate\Foundation\Http\FormRequest;

class StoreTicketRequest extends BaseTicketRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $authorIdAttr = $this->route('tickets.store')? 'data.relationalship.author.data.id':'author';
        $rules = [
            'data.attributes.title' => 'required|string|between:5,150',
            'data.attributes.description' => 'required|string|between:5,150',
            'data.attributes.status' => 'required|string|in:active,complete,holdOn,cancel',
            $authorIdAttr => 'required | integer : exists:users, id'
        ];

        $user = $this->user();

        if ($user->tokenCan(Abilities::CreateOwnTicket)) {
            $rules[$authorIdAttr] .= '|size' . $user->id;
        }


        return $rules;
    }

    protected function prepareForValidation()
    {
        if ($this->routeIs('authors.tickets.store')) {
            $this->merge([
                'author' => $this->route('author')
            ]);
        }
    }
}
