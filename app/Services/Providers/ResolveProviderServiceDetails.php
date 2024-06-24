<?php

namespace App\Services\Providers;

use App\Models\ProviderService;
use Illuminate\Support\Collection;

class ResolveProviderServiceDetails
{
    const EARTH_RADIUS = 6371;

    private float $providerToOriginDistance;
    private float $originToDestinyDistance;
    private float $destinyToProviderDistance;
    private float $totalDistance;
    private float $totalPrice;

    //TODO, APÓS CRIAR AS FACTORIES PARA DISTANCIAS, UTILIZAR O CONSTRUTOR...
    // public function __construct(CoordinatesFactory $providerCoordinates, CoordinatesFactory $originCoordinates, CoordinatesFactory $destinyCoordinates, ProviderService $service): array
    // {
    //     dd($providerLat);
    // }

    /**
     * 1. Realizar o calcula da distância entre o provedor até a origem, da origem ao destino, e do destino a origem, e então somar.
     * 2. Fazer o calculo do valor seguindo a formula recebida.
     */
    public function handle(string $providerLat, string $providerLon, string $originLat, string $originLon, string $destinyLat, string $destinyLon, ProviderService $service): array
    {
        $this->resolveDistances($providerLat, $providerLon, $originLat, $originLon, $destinyLat, $destinyLon);
        $this->resolveTotalPrice($service);
        
        return [
            'totalDistance' => $this->totalDistance,
            'totalPrice' => $this->totalPrice
        ];
    }

    private function resolveTotalPrice(ProviderService $service): void
    {
        $overKm = $this->totalDistance - $this->providerToOriginDistance;
        $this->totalPrice = $service->departure_price + ($overKm * $service->km_price);
    }

    private function resolveDistances(string $providerLat, string $providerLon, string $originLat, string $originLon, string $destinyLat, string $destinyLon): void
    {
        $this->providerToOriginDistance = self::harversineFormula($providerLat, $providerLon, $originLat, $originLon);
        $this->originToDestinyDistance = self::harversineFormula($originLat, $originLon, $destinyLat, $destinyLon);
        $this->destinyToProviderDistance = self::harversineFormula($destinyLat, $destinyLon, $providerLat, $providerLon);
        $this->totalDistance = $this->providerToOriginDistance + $this->originToDestinyDistance + $this->destinyToProviderDistance;
    }

    private static function harversineFormula(string $latFrom, string $lonFrom, string $latTo, string $lonTo)
    {
        $latFromToRadius = deg2rad($latFrom);
        $lonFromToRadius = deg2rad($lonFrom);
        $latToToRadius = deg2rad($latTo);
        $lonToToRadius = deg2rad($lonTo);

        $latDelta = $latToToRadius - $latFromToRadius;
        $lonDelta = $lonToToRadius - $lonFromToRadius;

        $a = sin($latDelta / 2) * sin($latDelta / 2) + cos($lonFromToRadius) * cos($latToToRadius) * sin($lonDelta / 2) * sin($lonDelta / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 -$a));

        return round(self::EARTH_RADIUS * $c, 2);
    }
}
