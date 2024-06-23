<?php

namespace App\Http\Controllers;

use App\Http\Requests\Providers\SearchAvailableProvidersRequest;
use App\Services\Providers\SearchAvailableProvidersService;
use Illuminate\Http\Request;

class ProviderController extends Controller
{
    public function index()
    {
        
    }

    public function search(SearchAvailableProvidersRequest $request, SearchAvailableProvidersService $service)
    {
        $service->search($request->validated());
    }

    public function show()
    {
        
    }

    public function store()
    {
        
    }

    public function destroy()
    {
        
    }
}
