<?php

namespace App\Http\Requests;

use App\Models\Team;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TeamRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255', 'unique:teams'],
            'kendra' => ['required', 'string', 'max:255'],
            'user_id' => ['required', 'numeric', 'unique:teams,user_id'],
            'members' => ['required', 'array'],
            'members.*' => ['required', 'array'],
            'members.*.name' => ['required', 'string', 'max:255'],
            'members.*.role' => ['required', 'string', 'max:255'],
        ];

        if (in_array($this->method(), ['PUT', 'PATCH'])) {
            $team = $this->route('team');
            $rules['name'] = [
                'required', 'string', 'max:255', Rule::unique(Team::class)->ignore($team),
            ];
            $rules['user_id'] = [
                'required', 'numeric',
                Rule::unique(Team::class)->ignore($team),
            ];
        }

        return $rules;
    }

    public function attributes()
    {
        return [
            'members.*.name' => 'Name',
            'members.*.role' => 'Role',
        ];
    }

    public function messages()
    {
        return [
            'members.required' => 'Please add at least one member.',
            'user_id.unique' => 'User already assigned to other team.',
        ];
    }
}
