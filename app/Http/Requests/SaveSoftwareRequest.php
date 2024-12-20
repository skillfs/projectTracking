<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveSoftwareRequest extends FormRequest
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
        return [
            'f_name' => 'required|string',
            'l_name' => 'required|string',
            'department_id' => 'required|exists:departments,department_id',
            'tel' => 'required|digits:10',
            'software_name' => 'required|string',
            'problem' => 'required|string',
            'purpose' => 'required|string',
            'target' => 'required|string',
            'date' => 'required|date',
        ];
    }
}
