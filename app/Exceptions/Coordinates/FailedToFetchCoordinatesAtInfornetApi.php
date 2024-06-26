<?php

namespace App\Exceptions\Coordinates;

use App\Exceptions\CustomException;
use Illuminate\Support\Facades\Log;

class FailedToFetchCoordinatesAtInfornetApi extends \Exception implements CustomException
{
    private array $details;

    public function __construct(array $details)
    {
        $this->details = $details['details'] ?? [];
        $this->message = "Ocorreu um erro inesperado ao buscar as coordenadas de um endereço na aplicação. Por favor, tente novamente mais tarde. Caso o erro persista contacte o suporte.";  
    }

    public function render()
    {
        $responseBody = ['message' => $this->message];

        if (env('APP_ENV') !== 'production') {
            $responseBody['details'] = $this->details;
        }

        return response()->json($responseBody, 500);
    }

    public function report()
    {
        $encodedDetails = json_encode($this->details);
        Log::error("Ocorreu um erro inesperado ao consumir a API de coordenadas da Infornet.\n Detalhes: {$encodedDetails} \n Trace: {$this->getTraceAsString()}.");
    }
}
