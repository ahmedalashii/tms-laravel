<?php

namespace App\Http\Requests\Trainee;

use Illuminate\Foundation\Http\FormRequest;

class TraineeRegistrationRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:trainees',
            'phone' => 'required|numeric|digits:10|unique:trainees',
            'address' => 'required|string|max:255',
            'gender' => 'required|string|in:male,female',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required',
            'avatar-image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'cv-file' => 'required|mimes:pdf,doc,docx|max:2048',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */

    public function messages(): array
    {
        return [
            'name.required' => 'Name is required',
            'name.string' => 'Name must be a string',
            'name.max' => 'Name must be less than 255 characters',
            'email.required' => 'Email is required',
            'email.string' => 'Email must be a string',
            'email.email' => 'Email must be a valid email address',
            'email.max' => 'Email must be less than 255 characters',
            'email.unique' => 'Email already exists',
            'phone.required' => 'Phone is required',
            'phone.numeric' => 'Phone must be a number',
            'phone.digits' => 'Phone must be 10 digits',
            'phone.unique' => 'Phone already exists',
            'address.required' => 'Address is required',
            'address.string' => 'Address must be a string'
        ];
    }
}
