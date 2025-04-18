<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MessageRequest extends FormRequest
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
			'sender_id' => 'required',
			'receiver_id' => 'required',
			'message' => 'required|string',
			'additional_details' => 'string',
			'typed_message' => 'string',
			'is_agreed' => 'required',
        ];
    }
}
