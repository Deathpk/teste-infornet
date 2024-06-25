<?php

namespace App\Services\Providers;

use App\Models\Provider;
use App\Services\Coordinates\FetchCoordinatesService;

class UpdateProviderService
{
    private FetchCoordinatesService $coordinateService;

    public function __construct()
    {
        $this->coordinateService = new FetchCoordinatesService();
    }

    public function handle(Provider $provider, array $data): void
    {
        dd($data);
    }
}
