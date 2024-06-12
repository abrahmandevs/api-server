<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class BaseTicketRequest extends FormRequest
{
    public function messages()
    {
        return [
            'data.attributes.status'=>'Status will be active, comple, cancele',
        ];
    }
}
