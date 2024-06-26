<?php

namespace App\Services\Providers;

use App\Models\Provider;
use App\Services\Coordinates\FetchCoordinatesService;
use App\Services\Coordinates\ResolveCoordinatesService;
use Exception;

class CreateProviderService
{
    public function __construct(
        private ResolveCoordinatesService $coordinateService = new ResolveCoordinatesService(),
        private array $providerData = []
    ){}

    public function handle(array $providerData)
    {
        $coordinates = $this->coordinateService->resolve(
            street: $providerData['street'],
            neighborhood: $providerData['neighborhood'],
            city: $providerData['city'],
        );

        $providerData['lat'] = $coordinates['lat'];
        $providerData['lon'] = $coordinates['lon'];

        try {
            Provider::create($providerData);
        } catch(Exception $e) {
            dd($e);
        }
    }
}
