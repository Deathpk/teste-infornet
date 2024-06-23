<?php

namespace App\Http\Requests\Providers;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class SearchAvailableProvidersRequest extends FormRequest
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
            'origin_city' => ['required'],
            'origin_uf' => ['required'],
            'origin_lat' => ['required', 'string'],
            'origin_long' => ['required', 'string'],
            'destiny_city' => ['required'],
            'destiny_uf' => ['required'],
            'destiny_lat' => ['required', 'string'],
            'destiny_long' => ['required', 'string'],
            'service_id' => ['required', 'exists:services,id'],
            'result_quantity' => ['sometimes','max:100'],
            'order_by' => ['array'],
            'filters' => ['array']
        ];
    }

    // public function messages(): array
    // {
    //     return [
    //         'origin_address.required' => 'O endereço de origem é obrigatório.',
    //         'destiny_address.required' => 'O endereço de destino é obrigatório.',
    //         'service_id.required' => 'O serviço requerido é obrigatório.',
    //         'service_id.exists' => 'O serviço informado não existe em nossa base de dados, por favor, tente novamente.',
    //         'result_quantity.max' => 'A quantidade de resultados deve ser inferior a 100.',
    //         'order_by.array' => 'A ordenação deve ser do tipo array.',
    //         'filters.array' => 'O filtro deve ser do tipo array.'
    //     ];
    // }
}
