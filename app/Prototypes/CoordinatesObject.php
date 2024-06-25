<?php

namespace App\Prototypes;

class CoordinatesObject
{
    public float $lat;
    public float $lon;

    public function __construct(string $lat, string $lon)
    {
        $this->lat = (float) $lat;
        $this->lon = (float) $lon;
    }

    public function convertLatToRadius(): float
    {
        return deg2rad($this->lat);
    }

    public function convertLonToRadius(): float
    {
        return deg2rad($this->lon);
    }
}
