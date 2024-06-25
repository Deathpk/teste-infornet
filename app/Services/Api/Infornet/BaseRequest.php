<?php

namespace App\Services\Api\Infornet;

use Illuminate\Http\Client\Response;

abstract class BaseRequest
{
    const INFORNET_BASE_URL = 'https://teste-infornet.000webhostapp.com/api';
    const HTTP_GET = 'GET';
    const HTTP_POST = 'POST';
    const HTTP_PUT = 'PUT';

    protected string $method;
    protected string $baseUrl;
    protected string $endpoint;
    protected ?string $body;

    abstract protected function handle(): array;
}
