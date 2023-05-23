<?php

namespace App\Http\Requests\Advisor;

use Illuminate\Foundation\Http\FormRequest;

class AdvisorRegistrationRequest extends FormRequest
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
            'email' => 'required|string|email|max:255|unique:advisors',
            'phone' => 'required|numeric|digits:10|unique:advisors',
            'address' => 'required|string|max:255',
            'gender' => 'required|string|in:male,female',
            'disciplines' => 'required|array|min:1',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required',
            'avatar-image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'cv-file' => 'required|mimes:pdf,doc,docx,txt,rtf,odt,ods,odp,odg,odc,odb,xls,xlsx,ppt,pptx',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Name is required',
            'email.required' => 'Email is required',
            'disciplines.required' => 'At least one discipline is required to be selected',
            'password.required' => 'Password is required',
            'password_confirmation.required' => 'Password confirmation is required',
        ];
    }
}
