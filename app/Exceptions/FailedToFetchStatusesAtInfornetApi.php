<?php

namespace App\Exceptions;

use Illuminate\Support\Facades\Log;

class FailedToFetchStatusesAtInfornetApi extends \Exception implements CustomException
{
    public function __construct()
    {
        $this->message = "Ocorreu um erro inesperado ao buscar o status de um ou mais Prestadores na aplicação. Por favor, tente novamente mais tarde. Caso o erro persista contacte o suporte.";  
    }

    public function report()
    {
        Log::error("Ocorreu um erro inesperado ao consumir a API de status da Infornet.\n Trace: {$this->getTraceAsString()}");
    }
}
