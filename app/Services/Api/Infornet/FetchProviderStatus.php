<?php

namespace App\Services\Api\Infornet;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;

class FetchProviderStatus extends BaseRequest
{
    private array $providerIds;

    public function __construct(array $providerIds)
    {
        $this->providerIds = $providerIds;
        $this->baseUrl = BaseRequest::INFORNET_BASE_URL;
        $this->method = BaseRequest::HTTP_GET;

        $this->endpoint = 'prestadores/online';
        $this->body = json_encode([
            'prestadores' => $this->providerIds
        ]);
    }

    public function handle(): array
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ])
        ->withBasicAuth(
            username:config('services.infornetClient.user'),
            password:config('services.infornetClient.password')
        )
        ->withBody(
            $this->body
        )
        ->get("$this->baseUrl/$this->endpoint")->json();

        return $response;
    }

    public static function getRandomOnlineStatusForTesting(): string
    {
        $availableStatus = ['Online', 'Offline'];
        $randKey = array_rand($availableStatus);
        return $availableStatus[$randKey];
    }
}
