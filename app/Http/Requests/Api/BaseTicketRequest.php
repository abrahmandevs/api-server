<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use PhpParser\Node\Expr\FuncCall;

class BaseTicketRequest extends FormRequest
{
    public function mappedAttributes(array $otherAttributes = [])
    {
        $attributeMap = array_merge([
            'data.attributes.title' => 'title',
            'data.attributes.description' => 'description',
            'data.attributes.status' => 'status',
            'data.relationalship.data.id' => 'user_id',
            'data.attributes.createdAt' => 'created_at',
            'data.attributes.updatedAt' => 'updated_at',
        ], $otherAttributes);

        $attrttributeToUpdate = [];
        foreach ($attributeMap as $key => $attribute) {
            if ($this->has($key)) {
                $attrttributeToUpdate[$attribute] = $key;
            }
        }

        return $attrttributeToUpdate;
    }

    public function messages()
    {
        return [
            'data.attributes.status' => 'Status will be active, comple, cancele',
        ];
    }
}
