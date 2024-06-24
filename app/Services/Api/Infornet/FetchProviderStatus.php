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
        //TODO RESOLVE WHY IS THE HOST NOT BEIGN RESOLVED...

        // $response = Http::dd()
        // ->withHeaders([
        //     'Content-Type' => 'application/json',
        //     'Accept' => 'application/json',
        // ])
        // ->withBasicAuth(
        //     username:config('services.infornetClient.user'),
        //     password:config('services.infornetClient.password')
        // )
        // ->withBody($this->body)
        // ->get("{$this->baseUrl}/{$this->endpoint}")->json();

        $responseMock = [
            'prestadores' => collect($this->providerIds)->map(function(int $id) {
                return [
                    'idPrestador' => $id,
                    'status' => self::getRandomOnlineStatus()
                ];
            })->toArray()
        ];

        return $responseMock;
    }

    private static function getRandomOnlineStatus(): string
    {
        $availableStatus = ['Online', 'Offline'];
        $randKey = array_rand($availableStatus);
        return $availableStatus[$randKey];
    }
}
