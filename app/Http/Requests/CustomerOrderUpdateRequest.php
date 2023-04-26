<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerOrderUpdateRequest extends FormRequest
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
            'desired_pick_up_date' => ['required'],
            'desired_delivery_date' => ['required'],
            'text' => ['sometimes'],
            'sender_id' => ['required'],
            'sender_type' => ['required', 'string'],
            'receiver_id' => ['required'],
            'receiver_type' => ['required', 'string'],
        ];
    }
}
