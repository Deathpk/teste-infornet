<?php

namespace Database\Factories;

use App\Models\Provider;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Provider>
 */
class ProviderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Illuminate\Database\Eloquent\Model>
     */
    protected $model = Provider::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    { //TODO
        $adressesMock = [
            [
                'street' => 'Rua Dom Rafael',
                'neighborhood' => 'Conjunto Taquaril',
                'number' => rand(),
                'city' => 'Belo Horizonte',
                'uf' => 'MG',
            ],
            [
                'street' => 'Rua R',
                'neighborhood' => 'Mariano de Abreu',
                'number' => rand(),
                'city' => 'Belo Horizonte',
                'uf' => 'MG',
            ],
            [
                'street' => 'Rua Albertino Roque',
                'neighborhood' => 'Iporanga',
                'number' => rand(),
                'city' => 'Sete Lagoas',
                'uf' => 'MG',
            ],
            [
                'street' => 'Rua Antônio Bleme Filho',
                'neighborhood' => 'Jardim Brasília',
                'number' => rand(),
                'city' => 'Betim',
                'uf' => 'MG',
            ],
        ];
        
        // $this->faker->locale('pt_BR');
        // return [
        //     'name' => $this->faker->company(),
        //     'street' => 
        // ];
        return [];
    }
}
