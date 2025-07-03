<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\HotelRepositoryInterface;
use App\Repositories\HotelRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            HotelRepositoryInterface::class,
            HotelRepository::class
        );
        // Registrar aquí más bindings si creas otros repositorios
    }
}
