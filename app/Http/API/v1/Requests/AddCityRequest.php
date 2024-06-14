<?php

namespace App\Http\API\v1\Requests;

class AddCityRequest extends \Illuminate\Foundation\Http\FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
    */
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string',
            'parent'   => 'exists:App\Models\Area,id'
        ];
    }
}
