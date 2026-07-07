<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Eloquent\ProductRepository;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Repositories\Eloquent\CategoryRepository;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Services\BrandService;
use App\Services\Interfaces\CategoryServiceInterface;
use App\Services\CategoryService;
use App\Services\Interfaces\ProductServiceInterface;
use App\Services\ProductService;
use App\Services\Interfaces\BrandServiceInterface;
use App\Repositories\Interfaces\BrandRepositoryInterface;
use App\Repositories\Eloquent\BrandRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            ProductRepositoryInterface::class,
            ProductRepository::class
        );
        $this->app->bind(
            CategoryRepositoryInterface::class,
            CategoryRepository::class
        );
        $this->app->bind(
            CategoryServiceInterface::class,
            CategoryService::class
        );
        $this->app->bind(
            ProductServiceInterface::class,
            ProductService::class
        );
        $this->app->bind(
            BrandServiceInterface::class,
            BrandService::class
        );
        $this->app->bind(
            BrandRepositoryInterface::class,
            BrandRepository::class
        );
    }


    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
