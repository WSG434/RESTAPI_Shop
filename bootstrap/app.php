<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
           'admin' => \App\Http\Middleware\AdminMiddleware::class,
           'product.draft' => \App\Http\Middleware\DraftProductMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions -> render(function (\App\Exceptions\Product\ProductNotFoundException $e){
               return responseFailed($e->getMessage(), $e->getCode());
        });
        $exceptions -> render(function (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e){
           return responseFailed(getMessage('route_not_found'), 404);
        });
        $exceptions -> render(function (\Illuminate\Auth\AuthenticationException $e){
            return responseFailed(getMessage('auth_error'), 401);
        });
    })->create();
