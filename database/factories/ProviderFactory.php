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
    {
        $this->faker->locale('pt_BR');
        $adressesMock = [
            [
                'street' => 'Rua Dom Rafael',
                'neighborhood' => 'Conjunto Taquaril',
                'number' => rand(1, 200),
                'city' => 'Belo Horizonte',
                'uf' => 'MG',
                'lat' => '-19.9174367',
                'lon' => '-43.8817798'
            ],
            [
                'street' => 'Rua R',
                'neighborhood' => 'Mariano de Abreu',
                'number' => rand(1, 200),
                'city' => 'Belo Horizonte',
                'uf' => 'MG',
                'lat' => '-19.8970494"',
                'lon' => '-43.890241'
            ],
            [
                'street' => 'Rua Maria Grossi Raniero',
                'neighborhood' => 'Pacaembu',
                'number' => rand(1, 200),
                'city' => 'Uberlândia',
                'uf' => 'MG',
                'lat' => '-18.8817322',
                'lon' => '-48.2939868'
            ],
        ];
        
        $randomAddressKey = array_rand($adressesMock, 1);
        $address = $adressesMock[$randomAddressKey];

        return [
            'name' => $this->faker->company,
            'street' => $address['street'],
            'neighborhood' => $address['neighborhood'],
            'number' => $address['number'],
            'city' => $address['city'],
            'uf' => $address['uf'],
            'lat' => $address['lat'],
            'lon' => $address['lon'],
        ];
    }
}
