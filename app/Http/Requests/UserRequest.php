<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
			'name' => 'required|string',
			'email' => 'required|string',
			'role' => 'required',
			'profile_image' => 'string',
			'location' => 'string',
			'availability' => 'required',
			'occupation' => 'required|string',
			'skills' => 'required|string',
			'valid_id' => 'required|string',
			'purok' => 'string',
			'street' => 'string',
        ];
    }
}
