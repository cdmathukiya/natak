<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateSpotsItemRequest extends FormRequest
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
        $rules = [
            'team_available_id' => ['required', 'numeric'],
            'date' => ['required'],
            'spots' => ['nullable', 'array'],
            'spots.*' => ['nullable', 'array'],
            'spots.*.id' => ['nullable', 'numeric', 'exists:team_spots,id'],
            'spots.*.spots_name' => ['required', 'string', 'max:255'],
            'spots.*.children' => ['required', 'string', 'max:255'],
            'spots.*.women' => ['required', 'string', 'max:255'],
            'spots.*.men' => ['required', 'string', 'max:255'],
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'spots.required' => 'Please add at least one member.',
            'date.unique' => 'The Team Already book for this date.',
        ];
    }
}
