<?php

namespace App\Http\Requests\api\v1\user;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
            'lastName' => 'required|string',
            'firstName' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,svg|max:2048'
        ];
    }
}
