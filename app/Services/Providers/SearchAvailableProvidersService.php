<?php

namespace App\Services\Providers;

use App\Models\Provider;
use App\Services\Api\Infornet\FetchProviderStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class SearchAvailableProvidersService
{
    private array $searchParams;
    private Builder $query;

    public function search(array $searchParams)
    {
        $this->setParams($searchParams);
        $this->setDefaultProvidersQuery();
        $this->applyFilterIfPresent();
        $this->fetchProvidersBasedOnParams();
    }

    private function setParams(array &$searchParams): void
    {
        $this->searchParams = $searchParams;
    }

    public function setDefaultProvidersQuery()
    {
        $this->query = Provider::query();
    }

    /**
     * 1. Fetch the providers, fetch quantity based on result_quantity Param. If not Present, the max Is 100.
     * 1.a TODO Apply the filters if present.
     * 2. For each provider, we must check their statuses using the Infornet Service.
     * 3. Order the results if order_by param present.
     */
    private function fetchProvidersBasedOnParams()
    {
        $maxResults = $this->searchParams['result_quantity'] ?? 100;
        $providers = $this->query->take($maxResults)->get();
        $providersIds = $providers->pluck('id')->toArray();
        $this->getProvidersStatus($providersIds);
    }

    private function getProvidersStatus(array $providersIds)
    {
        $client = new FetchProviderStatus($providersIds);
        $client->handle();
    }

    private function applyFilterIfPresent(): void
    {
        $hasFilters = isset($this->searchParams['filters']);
        
        if(!$hasFilters) {
            return;
        }

        $filters = collect($this->searchParams['filters']);
        $this->applyFiltersBeforeCheckingProviderStatus($filters);
    }

    private function applyFiltersBeforeCheckingProviderStatus(Collection &$filters): void
    {
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

    private function applyFiltersAfterCheckingProviderStatus()
    {
        // todo
    }
}
