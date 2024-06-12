<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTicketRequest extends BaseTicketRequest
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
        $rules= [
            'data.attributes.title'=>'sometimes|string|between:5,150',
            'data.attributes.description'=>'sometimes|string|between:5,150',
            'data.attributes.status'=>'sometimes|string|in:active,complete,holdOn,cancel',
            'data.relationalship.data.id'=>'sometimes|string|integerl',
        ];

        return $rules;
    }
}
