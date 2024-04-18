<?php

namespace App\Providers;

use App\Http\Resources\Product\ProductResource;
use App\Services\Product\ProductService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind('product', ProductService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        ProductResource::withoutWrapping();
    }
}
