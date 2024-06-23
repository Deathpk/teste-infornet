<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;

class RegisterUserRequest extends FormRequest
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
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:App\Models\User,email'],
            'password' => ['required', 'min:8'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O campo nome é obrigatório.',
            'name.string' => 'O campo nome deve conter somente caracteres alfa numéricos.',
            'email.required' => 'O campo e-mail é obrigatório',
            'email.email' => 'O e-mail inserido não é válido.',
            'email.unique' => 'O e-mail inserido já está sendo utilizado por outro usuário.',
            'password.required' => 'O campo senha é obrigatório.',
            'password.min' => 'O campo senha deve conter no mínimo 8 caractéres.',

        ];
    }
}
