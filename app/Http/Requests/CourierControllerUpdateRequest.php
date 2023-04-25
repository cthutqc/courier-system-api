<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourierControllerUpdateRequest extends FormRequest
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
            'name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'middle_name' => ['required', 'string'],
            'passport_series' => ['required',],
            'passport_number' => ['required'],
            'passport_issued_by' => ['required', 'string'],
            'passport_issued_date' => ['required', 'string'],
            'region' => ['required', 'string'],
            'city' => ['required', 'string'],
            'street' => ['required', 'string'],
            'house' => ['required'],
            'flat' => ['required'],
            'passport_photo_id' => ['required', 'image'],
            'passport_photo_address' => ['required', 'image']
        ];
    }
}
