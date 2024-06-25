<?php

namespace App\Http\Requests\Providers;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

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
            'name' => ['sometimes', 'string'],
            'street' => ['sometimes', 'string'],
            'neighborhood' => ['sometimes', 'string'],
            'number' => ['sometimes', 'numeric'],
            'city' => ['sometimes', 'string'],
            'uf' => ['sometimes', 'string'],
        ];
    }

    // public function messages(): array
    // {
    //     return [

    //     ];
    // }
}
