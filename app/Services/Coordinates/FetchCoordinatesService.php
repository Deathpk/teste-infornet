<?php

namespace App\Services\Coordinates;

use App\Services\Api\Infornet\FetchCoordinatesBasedOnAddress;

class FetchCoordinatesService
{    
    public function fetch(string $address): array
    {
        $client = new FetchCoordinatesBasedOnAddress($address);
        return $client->handle();
    }
}
