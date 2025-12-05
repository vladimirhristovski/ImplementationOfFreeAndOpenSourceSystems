<?php

namespace App\Http\Requests\Event;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use App\Enums\EventTypeEnum;


class EventUpdateRequest extends FormRequest
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
            'name' => [
                'required',
                'string',
                Rule::unique('events', 'name')->ignore($this->event),
            ],
            'description' => [
                'required',
                'string',
                'min:20',
            ],
            'type' => [
                'required',
                Rule::in(EventTypeEnum::cases()),
            ],
            'organizer_id' => [
                'required',
                Rule::exists('organizers', 'id'),
            ],
            'date' => 'required|date|after_or_equal:date',
        ];
    }
}
