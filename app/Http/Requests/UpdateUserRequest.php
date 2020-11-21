<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'required|integer|exists:App\Models\EventUser',
            'first_name' => 'required|string|max:30',
            'last_name' => 'required|string|max:30',
            'email' => "required|email|max:255|unique:App\Models\EventUser,email,{$this->get('id')}"
        ];
    }
}
