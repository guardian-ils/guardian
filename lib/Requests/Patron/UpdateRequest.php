<?php

namespace Guardian\Requests\Patron;

use Guardian\Requests\Request;

class UpdateRequest extends Request
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
          'name' => 'required|string',
          'library_card_number' => 'required|string',
          'address' => 'string',
          'phone' => 'alpha_dash',
          'email' => 'email',
          'birthday' => 'date',
          'branch_id' => 'required|uuid',
        ];
    }

    public function wantsJson()
    {
        return true;
    }
}
