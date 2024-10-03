<?php

namespace App\Providers;

use App\CategoryInterface;
use App\ExpenseInterface;
use App\Repositories\CategoryRepository;
use App\Repositories\ExpenseRepository;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            ExpenseInterface::class,
            ExpenseRepository::class
        );

        $this->app->bind(
            CategoryInterface::class,
            CategoryRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
          Schema::defaultStringLength(191);
    }
}
