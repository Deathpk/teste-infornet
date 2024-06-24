<?php

namespace App\Http\Requests\Coordinates;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class FetchCoordinatesRequest extends FormRequest
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
            'address' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'address.required' => 'O endereço para busca é obrigatório.',
            'address.string' => 'O endereço para busca deve conter somente caractéres alfa numéricos.',
        ];
    }
}
