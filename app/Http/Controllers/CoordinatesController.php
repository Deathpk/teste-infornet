<?php

namespace App\Http\Controllers;

use App\Http\Requests\Coordinates\FetchCoordinatesRequest;
use App\Services\Coordinates\FetchCoordinatesService;
use Illuminate\Http\JsonResponse;

class CoordinatesController extends Controller
{
    public function fetch(FetchCoordinatesRequest $request, FetchCoordinatesService $service): JsonResponse
    {
        $coordinates = $service->fetch($request->get('address'));
        return response()->json($coordinates);
    }
}
