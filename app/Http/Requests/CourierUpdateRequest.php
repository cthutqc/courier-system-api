<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourierUpdateRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'last_name' => ['required'],
            'sure_name' => ['required'],
            'email' => ['required', 'email'],
            'phone' => ['required'],
            'active' => ['sometimes'],
            'address' => ['required'],
            'passport_series' => ['required'],
            'passport_number' => ['required'],
            'passport_issued_date' => ['required'],
            'passport_issued_by' => ['required'],
        ];
    }
}