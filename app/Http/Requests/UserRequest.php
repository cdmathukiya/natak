<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'max:50', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'is_active' => ['required', 'boolean'],
            'address' => ['nullable', 'string'],
            'team_id' => ['required', 'numeric', 'unique:users,team_id'],
        ];

        if (in_array($this->method(), ['PUT', 'PATCH'])) {
            $user = $this->route('user');
            $rules['email'] = [
                'required', 'email', 'max:50',
                Rule::unique(User::class)->ignore($user),
            ];
            $rules['team_id'] = [
                'required', 'numeric',
                Rule::unique(User::class)->ignore($user),
            ];
            $rules['password'] = ['sometimes', 'nullable', 'string', 'min:8', 'max:255'];
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'team_id.unique' => 'Team already assigned to other user.',
        ];
    }
}
