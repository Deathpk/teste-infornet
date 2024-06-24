<?php

namespace App\Http\Requests\Service;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateService extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3']
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O nome do serviço é obrigatório.',
            'name.string' => 'O nome do serviço deve conter apenas caracteres alfa numéricos.',
            'name.min' => 'O nome do serviço deve conter no mínimo 3 caracteres.',
        ];
    }
}
