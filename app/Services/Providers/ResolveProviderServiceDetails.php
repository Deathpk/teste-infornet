<?php

namespace App\Services\Providers;

use App\Models\ProviderService;
use App\Prototypes\CoordinatesObject;
use Illuminate\Support\Collection;

class ResolveProviderServiceDetails
{
    const EARTH_RADIUS = 6371;

    private CoordinatesObject $providerCoordinates; 
    private CoordinatesObject $originCoordinates;
    private CoordinatesObject $destinyCoordinates;
    private ProviderService $service;

    private float $providerToOriginDistance;
    private float $originToDestinyDistance;
    private float $destinyToProviderDistance;
    private float $totalDistance;
    private float $totalPrice;

    public function __construct(
        CoordinatesObject $providerCoordinates, 
        CoordinatesObject $originCoordinates, 
        CoordinatesObject $destinyCoordinates, 
        ProviderService $service
    )
    {
        $this->providerCoordinates = $providerCoordinates;
        $this->originCoordinates = $originCoordinates;
        $this->destinyCoordinates = $destinyCoordinates;
        $this->service = $service;
    }

    public function handle(): array
    {
        $this->resolveDistances();
        $this->resolveTotalPrice();
        
        return [
            'totalDistance' => $this->totalDistance,
            'totalPrice' => (float) number_format($this->totalPrice, 2)
        ];
    }

    private function resolveTotalPrice(): void
    {
        $overKm = $this->totalDistance - $this->providerToOriginDistance;
        $this->totalPrice = $this->service->departure_price + ($overKm * $this->service->km_price);
    }

    private function resolveDistances(): void
    {
        $this->providerToOriginDistance = self::harversineFormula($this->providerCoordinates, $this->originCoordinates);
        $this->originToDestinyDistance = self::harversineFormula($this->originCoordinates, $this->destinyCoordinates);
        $this->destinyToProviderDistance = self::harversineFormula($this->destinyCoordinates, $this->providerCoordinates);
        $this->totalDistance = $this->providerToOriginDistance + $this->originToDestinyDistance + $this->destinyToProviderDistance;
    }

    private static function harversineFormula(CoordinatesObject $from, CoordinatesObject $to)
    {
        $latFrom = $from->convertLatToRadius();
        $lonFrom = $from->convertLonToRadius();
        $latTo = $to->convertLatToRadius();
        $lonTo = $to->convertLonToRadius();

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $a = sin($latDelta / 2) * sin($latDelta / 2) + cos($lonFrom) * cos($latTo) * sin($lonDelta / 2) * sin($lonDelta / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 -$a));

        return round(self::EARTH_RADIUS * $c, 2);
    }
}