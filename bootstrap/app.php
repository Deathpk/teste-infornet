<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (NotFoundHttpException $e, Request $request) {
                return response()->json([
                    'message' => 'A entidade que procura não foi encontrada em nosso banco.'
                ], 404);
        });

        $exceptions->respond(function (Response $response) {
            if ($response->getStatusCode() === 500) {
                return response()->json([
                    'message' => 'Oops, ocorreu um erro inesperado, por favor, tente novamente mais tarde. Caso o erro persista contacte o suporte.',
                ], 500);
            }
     
            return $response;
        });

        $exceptions->dontReportDuplicates();
    })->create();
