<?php

namespace App\Http\Requests\Event;

use Illuminate\Foundation\Http\FormRequest;

class EventStoreRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'description' => 'required|string|min:20',
            'type' => ['required', Rule::in(EventTypeEnum::cases())],
            'organizer_id' => 'required|exists:organizers,id',
            'date' => 'required|date|after_or_equal:today',
        ];
    }
}
