<?php

namespace App\Services\Providers;

use App\Models\Provider;
use App\Prototypes\CoordinatesObject;
use App\Services\Api\Infornet\FetchProviderStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class SearchAvailableProvidersService
{
    private array $searchParams;
    private Builder $query;
    private Collection $providers;
    private array $providersStatuses;
    private Collection $result;

    public function search(array $searchParams): array
    {
        $this->setParams($searchParams);
        $this->setDefaultProvidersQuery();
        $this->applyFiltersBeforeCheckingProviderStatus();
        $this->fetchProvidersBasedOnParams();

        if ($this->providers->isEmpty()) {
            return [];
        }

        $this->getProvidersStatuses();
        $this->resolveProvidersResult();
        $this->applyStatusFilterIfNeeded();
        
        return $this->result->toArray();
    }

    private function setParams(array &$searchParams): void
    {
        $this->searchParams = $searchParams;
    }

    public function setDefaultProvidersQuery(): void
    {
        $this->query = Provider::query();
    }

    private function fetchProvidersBasedOnParams(): void
    {
        $maxResults = $this->searchParams['result_quantity'] ?? 100;

        $this->providers = $this->query
        ->withWhereHas('services', function ($query) {
            $query->where('provider_service_id', $this->searchParams['service_id']);
        })
        ->take($maxResults)->get();
    }

    private function resolveProvidersResult(): void
    {
        $statuses = collect($this->providersStatuses['prestadores']);

        $this->result = $this->providers->map(function(Provider $provider) use($statuses) {
            $coordinateObjects = $this->getCoordinateObjects($provider);

            $serviceDetails = new ResolveProviderServiceDetails(
                $coordinateObjects['provider'],
                $coordinateObjects['origin'],
                $coordinateObjects['destiny'],
                $provider->services()->first()
            );

            $details = $serviceDetails->handle();

            return [
                'id' => $provider->id,
                'name' => $provider->name,
                'street' => $provider->street,
                'neighborhood' => $provider->neighborhood,
                'number' => $provider->number,
                'city' => $provider->city,
                'uf' => $provider->uf,
                'status' => strtolower($statuses->firstWhere('idPrestador', $provider->id)['status']),
                'serviceDetails' => $details
            ];
        });
    }

    private function getCoordinateObjects(Provider &$provider): array
    {
        $providerCoordinates = new CoordinatesObject(
            $provider->lat, 
            $provider->lon
        );
        $originCoordinates = new CoordinatesObject(
            $this->searchParams['origin_lat'], 
            $this->searchParams['origin_lon']
        );
        $destinyCoordinates = new CoordinatesObject(
            $this->searchParams['destiny_lat'],
            $this->searchParams['destiny_lon']
        );

        return [
            'provider' => $providerCoordinates,
            'origin' => $originCoordinates,
            'destiny' => $destinyCoordinates,
        ];
    }

    private function getProvidersStatuses(): void
    {
        $providersIds = $this->providers->pluck('id')->toArray();
        $client = new FetchProviderStatus($providersIds);
        $this->providersStatuses = $client->handle();
    }

    private function getFiltersIfPresent(): Collection
    {
        $hasFilter = isset($this->searchParams['filters']);

        if($hasFilter) {
            return collect($this->searchParams['filters']);
        }

        return collect();
    }

    private function applyFiltersBeforeCheckingProviderStatus(): void
    { 
        $filters = $this->getFiltersIfPresent();

        if($filters->isEmpty()) {
            return;
        }

        $filters->each(function (?string $value, string $filter) {
            if(!$value) {
                return;
            }
            
            if($filter === 'city') {
                $this->query->where('city', $value);
            }

            if($filter === 'uf') {
                $this->query->where('uf', strtoupper($value));
            }
        });
    }

    private function applyStatusFilterIfNeeded(): void
    {
        $providerStatus = $this->getFiltersIfPresent()?->get('provider_status');

        if(!$providerStatus) {
            return;
        }

        $this->result = $this->result->filter(function(array $result) use(&$providerStatus) {
            return $result['status'] == $providerStatus;
        });
    }
}
