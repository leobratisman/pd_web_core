<?php

namespace App\Http\Requests\Date;

use App\Rules\DateTypeValue;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'event_date' => 'nullable|date',
            'description' => 'nullable|string',
            'type_of_event' => ['required', new DateTypeValue]
        ];
    }
}
