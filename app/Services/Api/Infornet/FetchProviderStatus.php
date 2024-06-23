<?php

namespace App\Services\Api\Infornet;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;

class FetchProviderStatus extends BaseRequest
{
    public function __construct(array $providerIds)
    {
        $this->baseUrl = BaseRequest::INFORNET_BASE_URL;
        $this->method = BaseRequest::HTTP_GET;

        $this->endpoint = 'prestadores/online';
        $this->body = json_encode([
            'prestadores' => $providerIds
        ]);
    }

    public function handle(): Response
    {
        $response = Http::withBasicAuth(
            username:config('services.infornetClient.user'),
            password:config('services.infornetClient.password')
        )
        ->withBody($this->body)
        ->get("{$this->baseUrl}/{$this->endpoint}");
        dd($response->status());
    }
}
