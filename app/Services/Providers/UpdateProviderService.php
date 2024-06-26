<?php

namespace App\Services\Providers;

use App\Models\Provider;
use App\Services\Coordinates\FetchCoordinatesService;
use App\Services\Coordinates\ResolveCoordinatesService;

class UpdateProviderService
{
    
    public function __construct(
        private ResolveCoordinatesService $coordinateService = new ResolveCoordinatesService()
    ){}

    public function handle(Provider $provider, array $data): void
    {
        $addressKeys = ['street', 'neighborhood', 'city', 'uf'];
        $shouldUpdateCoordinates = collect($data)->hasAny($addressKeys);

        if ($shouldUpdateCoordinates) {
            $coordinates = $this->coordinateService->resolve(
                street: $data['street'] ?? $provider->street,
                neighborhood: $data['neighborhood'] ?? $provider->neighborhood,
                city: $data['city'] ?? $provider->city,
            );
        }

        $provider->update([
            'street' => $data['street'] ?? $provider->street,
            'neighborhood' => $data['neighborhood'] ?? $provider->neighborhood,
            'city' => $data['city'] ?? $provider->city,
            'lat' => $coordinates['lat'] ?? $provider->lat,
            'lon' => $coordinates['lon'] ?? $provider->lon,
        ]);
    }
}
