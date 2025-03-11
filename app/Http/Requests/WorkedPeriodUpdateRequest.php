<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WorkedPeriodUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'start' => 'nullable|date_format:H:i:s',
            'end' => 'nullable|date_format:H:i:s',
            'tag' => 'nullable|string',
        ];
    }
}
