<?php

namespace App\Services\Api\Infornet;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;

class FetchCoordinatesBasedOnAddress extends BaseRequest
{
    public function __construct(string $address)
    {
        $this->baseUrl = BaseRequest::INFORNET_BASE_URL;
        $this->method = BaseRequest::HTTP_GET;
        $this->endpoint = "endereco/geocode/{$address}";
    }

    public function handle(): array
    {
        //TODO RESOLVE HOST ERROR...
        // $response = Http::withHeaders([
        //     'Content-Type' => 'application/json',
        //     'Accept' => 'application/json',
        // ])
        // ->withBasicAuth(
        //     username:config('services.infornetClient.user'),
        //     password:config('services.infornetClient.password')
        // )->get("{$this->baseUrl}/{$this->endpoint}");
        $responseMock = [
            'lat' => '-19.8195176',
            'lon' => '-43.9533807'
        ];

        return $responseMock;
    }
}
