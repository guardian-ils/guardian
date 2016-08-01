<?php

namespace Guardian\Requests\Branch;

use Guardian\Requests\Request;

class CreateRequest extends Request
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|unique:branches|string',
            'email' => 'email',
            'address' => 'string',
            'phone' => 'alpha_dash'
        ];
    }
}
