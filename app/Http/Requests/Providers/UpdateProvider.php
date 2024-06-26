<?php

namespace App\Http\Requests\Providers;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UpdateProvider extends FormRequest
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
            'name' => [
                'sometimes', 
                'string', 
                Rule::unique('providers', 'name')->ignore(request()->provider->id)
            ],
            'street' => ['sometimes', 'string'],
            'neighborhood' => ['sometimes', 'string'],
            'number' => ['sometimes', 'numeric'],
            'city' => ['sometimes', 'string'],
            'uf' => ['sometimes', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.string' => 'O nome do Prestador deve conter somente caractéres alfa numéricos.',
            'name.unique' => 'Este nome já está sendo utilizado por outro prestador.',
            'street.string' => 'O nome da rua deve conter somente caractéres alfa numéricos.',
            'neighborhood.string' => 'O nome do bairro deve conter somente caractéres alfa numéricos.',
            'number.numeric' => 'O numero é deve ser composto somente por números.',
            'city.string' => 'O nome da cidade deve conter somente caractéres alfa numéricos.',
            'uf.string' => 'A sigla do estado deve conter somente caractéres alfa numéricos.',
        ];
    }
}
