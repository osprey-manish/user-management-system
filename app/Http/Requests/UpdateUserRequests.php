<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateUserRequests extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'     => 'sometimes|required|string|max:255',
            'email'    => 'sometimes|required|email|unique:users,email,' . $this->route('user'),
            'password' => ['required','string','min:8','regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*(_|[^a-zA-Z0-9])).+$/'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'     => 'Name is required when provided.',
            'name.string'       => 'Name must be a valid string.',
            'name.max'          => 'Name must not exceed 255 characters.',

            'email.required'    => 'Email is required when provided.',
            'email.email'       => 'Email must be a valid email address.',
            'email.unique'      => 'Email already exists.',

            'password.required' => 'Password is required when provided.',
            'password.string'   => 'Password must be a valid string.',
            'password.min'      => 'Password must be at least 8 characters long.',
            'password.regex'    => 'The password must contain at least one lowercase letter, one uppercase letter, one digit, and one special character.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'status'  => false,
                'message' => 'Validation failed',
                'errors'  => $validator->errors()
            ], 422)
        );
    }
}
