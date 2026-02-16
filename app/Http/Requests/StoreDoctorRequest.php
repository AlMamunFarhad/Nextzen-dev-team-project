<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDoctorRequest extends FormRequest
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
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string|max:100',
            'specialization' => 'required|string|max:100',
            'experience' => 'required|integer|min:0',
            'consultation_fee' => 'required|numeric|min:0',
            'bio' => 'nullable|string',
            'status' => 'nullable|boolean',
        ];
    }
}
