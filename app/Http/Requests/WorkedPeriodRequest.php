<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WorkedPeriodRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'date' => 'required|date',
            'start' => 'required|date_format:H:i:s',
            'end' => 'required|date_format:H:i:s',
            'tag' => 'nullable|string',
        ];
    }
}
