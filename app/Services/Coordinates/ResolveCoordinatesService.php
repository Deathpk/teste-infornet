<?php

namespace App\Services\Coordinates;

class ResolveCoordinatesService
{
    public function __construct(
        private FetchCoordinatesService $coordinateService = new FetchCoordinatesService(),
    ){}

    public function resolve(string $street, string $neighborhood, string $city): array
    {
        $formattedAddress = "{$street}, {$neighborhood}, {$city}";
        return $this->coordinateService->fetch($formattedAddress);
    }
}
