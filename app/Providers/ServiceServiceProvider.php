<?php
// app/Providers/ServiceServiceProvider.php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\HotelRepositoryInterface;
use App\Repositories\HotelRepository;
use App\Services\HotelServiceInterface;
use App\Services\HotelService;

class ServiceServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Repository
        $this->app->bind(HotelRepositoryInterface::class, HotelRepository::class);
        // Service
        $this->app->bind(HotelServiceInterface::class, HotelService::class);
        
    }
}
