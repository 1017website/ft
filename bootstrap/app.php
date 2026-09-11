<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->respond(function (Response $response, Throwable $exception, Request $request) {
            $status = $response->getStatusCode();

            if ($status < 400 || $request->expectsJson() || ! str_contains($response->headers->get('Content-Type', ''), 'text/html')) {
                return $response;
            }

            // Keep error rendering independent of CMS data and database availability.
            $response->setContent(view('errors.status', ['status' => $status])->render());
            $response->headers->remove('Content-Length');

            return $response;
        });
    })->create();
