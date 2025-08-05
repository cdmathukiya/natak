<?php

namespace App\Http\Requests;

use App\Models\TeamAvailable;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TeamAvailableRequest extends FormRequest
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
            'team_id' => ['required', 'numeric'],
            'date' => [
                'required',
                Rule::unique(TeamAvailable::class)->where(function ($query) {
                    $query->where('team_id', $this->team_id);
                }),
            ],
            'members' => ['required', 'array'],
            'members.*' => ['required', 'array'],
            'members.*.member_id' => ['required', 'integer', 'exists:members,id'],
            'members.*.name' => ['required', 'string', 'max:255'],
            'members.*.role' => ['required', 'string', 'max:255'],
            'members.*.is_available' => ['boolean'],
        ];

        if (in_array($this->method(), ['PUT', 'PATCH'])) {
            $teamAvailable = $this->route('teamAvailable');
            $rules['date'] = [
                'required',
                Rule::unique(TeamAvailable::class)->where(function ($query) {
                    $query->where('team_id', $this->team_id);
                })->ignore($teamAvailable),
            ];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'members.required' => 'Please add at least one member.',
            'date.unique' => 'The Team Already book for this date.',
        ];
    }
}
