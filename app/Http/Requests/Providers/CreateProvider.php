<?php

namespace App\Http\Requests\Providers;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateProvider extends FormRequest
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
            'name' => ['required', 'string', 'unique:providers,name'],
            'street' => ['required', 'string'],
            'neighborhood' => ['required', 'string'],
            'number' => ['required', 'numeric'],
            'city' => ['required', 'string'],
            'uf' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O nome do Prestador é obrigatório.',
            'name.string' => 'O nome do Prestador deve conter somente caractéres alfa numéricos.',
            'name.unique' => 'Este nome já está sendo utilizado por outro prestador.',
            'street.required' => 'O nome da rua é obrigatório.',
            'street.string' => 'O nome da rua deve conter somente caractéres alfa numéricos.',
            'neighborhood.required' => 'O nome do bairro é obrigatório.',
            'neighborhood.string' => 'O nome do bairro deve conter somente caractéres alfa numéricos.',
            'number.required' => 'O numero é obrigatório.',
            'number.numeric' => 'O numero é deve ser composto somente por números.',
            'city.required' => 'O nome da cidade é obrigatório.',
            'city.string' => 'O nome da cidade deve conter somente caractéres alfa numéricos.',
            'uf.required' => 'A sigla do estado é obrigatório.',
            'uf.string' => 'A sigla do estado deve conter somente caractéres alfa numéricos.',
        ];
    }
}
