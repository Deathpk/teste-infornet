<?php

namespace App\Http\Controllers;

use App\Http\Requests\Providers\SearchAvailableProvidersRequest;
use App\Http\Requests\Providers\UpdateProvider;
use App\Models\Provider;
use App\Services\Providers\SearchAvailableProvidersService;
use App\Services\Providers\UpdateProviderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProviderController extends Controller
{
    public function search(SearchAvailableProvidersRequest $request, SearchAvailableProvidersService $service)
    {
        $providers = $service->search($request->validated());
        return response()->json(['providers' => $providers]);
    }

    public function show(Provider $provider): JsonResponse
    {
        return response()->json([
            'provider' => [
                'name' => $provider->name,
                'street' => $provider->street,
                'neighborhood' => $provider->neighborhood,
                'number' => $provider->number,
                'city' => $provider->city,
                'uf' => $provider->uf,
                'lat' => $provider->lat,
                'lon' => $provider->lon,
                'services' => $provider->services
            ],
        ]);
    }

    public function update(Provider $provider, UpdateProvider $request, UpdateProviderService $service)
    {
        $service->handle($provider, $request->validated());
    }

    public function store()
    {
        //todo
    }

    public function destroy()
    {
        //todo
    }
}
