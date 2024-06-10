<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class ReplaceTicketRequest extends FormRequest
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
            'data.attributes.title'=>'required|string|between:5,150',
            'data.attributes.description'=>'required|string|between:5,150',
            'data.attributes.status'=>'required|string|in:active,complete,holdOn,cancel',
            'data.relationalship.data.id'=>'required|string|integerl',
        ];

        return $rules;
    }
}
