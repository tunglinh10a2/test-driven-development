<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\ArticleRepository;
use App\Repositories\ArticleRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{

    protected $services = [
        ArticleRepositoryInterface::class => ArticleRepository::class
    ];
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        foreach ($this->services as $interface => $implement) {
            $this->app->bind($interface, $implement);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
