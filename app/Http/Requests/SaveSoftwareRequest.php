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
            'name' => 'required|max:191',
            'tel' => 'required|min:10',
            'software_name' => 'required|max:191',
            'date' => 'required',
            'problem' => 'required',
            'purpose' => 'required|max:191',
            'target' => 'nullable|min:3',
            'status' => 'required'
        ];
    }
}
