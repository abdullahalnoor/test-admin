<?php

namespace App\Providers;


use Illuminate\Support\ServiceProvider;

use Blade;
use Session;

use App\Repositories\Category\CategoryInterface;
use App\Repositories\Category\CategoryRepository;

use App\Repositories\Product\ProductInterface;
use App\Repositories\Product\ProductRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CategoryInterface::class, CategoryRepository::class);
        $this->app->bind(ProductInterface::class, ProductRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::directive('toastr', function ($expression){
            return "<script>
                    toastr.{{ Session::get('alert-type') }}($expression)
                 </script>";
        });
    }
}
