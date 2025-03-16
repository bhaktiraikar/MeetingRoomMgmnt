<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookMeetingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
{
    return [
        'meeting_name' => 'required|string|max:255',
        'date_time' => 'required|date|after:now',
        'duration' => 'required|in:30,60,90',
        'members' => 'required|integer|min:1|max:15',
        'meeting_room_id' => 'required|exists:meeting_rooms,id',
    ];
}

}
