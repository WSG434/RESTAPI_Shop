<?php

namespace App\Http\Middleware;

use App\Enums\ProductStatus;
use App\Exceptions\Product\ProductNotFoundException;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DraftProductMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $product =  $request->route('product');

        if ($product->isDraft()){
            throw new ProductNotFoundException();
        }

        return $next($request);
    }
}
