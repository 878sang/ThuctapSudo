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
use App\Services\Interfaces\CartServiceInterface;
use App\Services\CartService;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use App\Repositories\Eloquent\OrderRepository;
use App\Services\Interfaces\OrderServiceInterface;
use App\Services\OrderService;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Eloquent\UserRepository;
use App\Services\Interfaces\UserServiceInterface;
use App\Services\UserService;
use App\Repositories\Eloquent\ReviewRepository;
use App\Repositories\Interfaces\ReviewRepositoryInterface;
use App\Services\Interfaces\ReviewServiceInterface;
use App\Services\ReviewService;
use App\Repositories\Eloquent\UserAddressRepository;
use App\Repositories\Interfaces\UserAddressRepositoryInterface;
use App\Services\Interfaces\UserAddressServiceInterface;
use App\Services\UserAddressService;
use App\Repositories\Eloquent\CouponRepository;
use App\Repositories\Interfaces\CouponRepositoryInterface;
use App\Services\Interfaces\CouponServiceInterface;
use App\Services\CouponService;

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
        $this->app->bind(
            CartServiceInterface::class,
            CartService::class
        );
        $this->app->bind(
            OrderRepositoryInterface::class,
            OrderRepository::class
        );
        $this->app->bind(
            OrderServiceInterface::class,
            OrderService::class
        );
        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class
        );
        $this->app->bind(
            UserServiceInterface::class,
            UserService::class
        );
        $this->app->bind(
            ReviewRepositoryInterface::class,
            ReviewRepository::class
        );
        $this->app->bind(
            ReviewServiceInterface::class,
            ReviewService::class
        );
        $this->app->bind(
            UserAddressRepositoryInterface::class,
            UserAddressRepository::class
        );
        $this->app->bind(
            UserAddressServiceInterface::class,
            UserAddressService::class
        );
        $this->app->bind(
            CouponRepositoryInterface::class,
            CouponRepository::class
        );
        $this->app->bind(
            CouponServiceInterface::class,
            CouponService::class
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
