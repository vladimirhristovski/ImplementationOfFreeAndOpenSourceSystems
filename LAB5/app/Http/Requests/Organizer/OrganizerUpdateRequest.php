<?php

namespace App\Http\Requests\Organizer;
use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;

class OrganizerUpdateRequest extends FormRequest
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
            'full_name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('organizers')->ignore($this->organizer->id),
            ],
            'phone' => [
                'required',
                'string',
                'max:20',
                Rule::unique('organizers')->ignore($this->organizer->id),
            ],
        ];
    }
}
