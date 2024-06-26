<?php

namespace Database\Seeders;

use App\Models\Provider;
use App\Models\Service;
use Database\Factories\ProviderFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $providers = Provider::factory()->count(25)->create();
        $defaultServices = Service::all();
        
        $providers->each(function(Provider $provider) use(&$defaultServices) {
            $defaultServices->each(function(Service $service) use(&$provider) {
                $provider->services()->create([
                    'provider_id' => $provider->id,
                    'provider_service_id' => $service->id,
                    'departure_km' => 0,
                    'departure_price' => (float) rand(20, 70),
                    'km_price' => (float) rand(5, 20),
                ]);
            });
        });
    }
}
