<?php

namespace App\Services\Providers;

use App\Models\Provider;
use App\Services\Api\Infornet\FetchProviderStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class SearchAvailableProvidersService
{
    private ResolveProviderServiceDetails $detailsService;
    private array $searchParams;
    private Builder $query;
    private Collection $providers;
    private array $providersStatuses;
    private Collection $result;

    public function __construct()
    {
        $this->detailsService = new ResolveProviderServiceDetails();
    }

    public function search(array $searchParams): array
    {
        $this->setParams($searchParams);
        $this->setDefaultProvidersQuery();
        $this->applyFiltersBeforeCheckingProviderStatus();
        $this->fetchProvidersBasedOnParams();
        $this->applyStatusFilterIfNeeded();
        $this->detailsService->resolveDetails($this->result);
        
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
        $this->providers = $this->query->take($maxResults)->get();
        $this->getProvidersStatuses();
        $this->resolveProvidersResult();
    }

    private function resolveProvidersResult(): void
    {
        $statuses = collect($this->providersStatuses['prestadores']);

        $this->result = $this->providers->map(function(Provider $provider) use($statuses) {
            return [
                'id' => $provider->id,
                'name' => $provider->name,
                'street' => $provider->public_place,
                'neighborhood' => $provider->neighborhood,
                'number' => $provider->number,
                'city' => $provider->city,
                'uf' => $provider->uf,
                'status' => strtolower($statuses->firstWhere('idPrestador', $provider->id)['status'])
            ];
        });
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

        //TODO APLICAR STRATEGY
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
