<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEventRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => 'required|integer|exists:App\Models\Event',
            'title' => 'required|string|max:255',
            'date' => 'required|date|date_format:Y-m-d H:i:s',
            'city' => 'required|string|max:200'
        ];
    }
}
