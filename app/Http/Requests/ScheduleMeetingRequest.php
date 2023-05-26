<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ScheduleMeetingRequest extends FormRequest
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
    public function rules(Request $request): array
    {
        /*
           A Trainee can also request for a meeting with his advisor. In requesting a 
            meeting, the application must resolve any conflicts (e. g., If two trainees 
            requesting a meeting with the same advisor at the same time).
        */
        return [
            'advisor' => 'required|exists:advisors,id',
            'date' => 'required|date|after_or_equal:today|not_in:' . $request->advisor . ',' . $request->time,
            'time' => [
                'required',
                'date_format:H:i',
                Rule::when($request->date === date('Y-m-d'), function ($request) {
                    // The time chosen must be after 2 hours from now >> it's 2 hours from now but there's one hour difference between the server and the client
                    if (!Carbon::parse($request->time)->isAfter(Carbon::now()->addHours(3))) {
                        $valid_time = Carbon::now()->addHours(5)->format('H:i A');
                        return 'after:' . $valid_time;
                    }
                }),
                'not_in:' . $request->advisor . ',' . $request->date,
            ],
            'location' => 'required|string|max:255',
            'notes' => 'nullable|string|max:255',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */

    public function messages(): array
    {
        return [
            'advisor_id.required' => 'Advisor is required',
            'advisor_id.exists' => 'Advisor does not exist',
            'date.required' => 'Date is required',
            'date.date' => 'Date must be a valid date',
            'date.not_in' => 'Date is not available for this advisor at this time',
            'time.required' => 'Time is required',
            'time.date_format' => 'Time must be a valid time',
            'time.after' => 'Time must be after 2 hours from now',
            'time.not_in' => 'Time is not available for this advisor at this date',
            'location.required' => 'Location is required',
            'location.string' => 'Location must be a string',
            'location.max' => 'Location must not be greater than 255 characters',
            'notes.string' => 'Notes must be a string',
            'notes.max' => 'Notes must not be greater than 255 characters',
        ];
    }
}
