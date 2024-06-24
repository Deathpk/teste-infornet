<?php

namespace App\Http\Controllers;

use App\Http\Requests\Service\CreateService;
use App\Http\Requests\Service\UpdateService;
use App\Models\Service;
use App\Services\Service\CreateServiceService;
use App\Services\Service\FetchAvailableServicesService;
use App\Services\Service\UpdateServiceService;
use Illuminate\Http\JsonResponse;

class ServiceController extends Controller
{
    public function index(FetchAvailableServicesService $service): JsonResponse
    {
        $services = $service->handle();
        return response()->json([
            'services' => $services
        ]);
    }
    
    public function show(Service $service)
    {
        return response()->json([
            'service' => $service
        ]);
    }

    public function store(CreateService $request, CreateServiceService $service)
    {
        $service->handle($request->get('name'));
        return response()->json([
            'message' => 'Serviço criado com sucesso!'
        ], 201);
    }

    public function update(Service $service, UpdateService $request, UpdateServiceService $updateService)
    {
        $updateService->handle($service, $request->get('name'));
        return response()->json([
            'message' => 'Serviço atualizado com sucesso!'
        ]);
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return response()->json([
            'message' => 'Serviço excluído com sucesso!'
        ]);
    }
}
