<?php
// app/Http/Controllers/HotelController.php

namespace App\Http\Controllers;

use App\Services\HotelServiceInterface;
use App\Http\Resources\HotelCollection;
use App\Http\Resources\HotelResource;
use App\Http\Requests\StoreHotelRequest;
use App\Http\Requests\UpdateHotelRequest;
use App\Models\Hotel;

class HotelController extends Controller
{
    private HotelServiceInterface $hotelService;

    public function __construct(HotelServiceInterface $hotelService)
    {
        $this->hotelService = $hotelService;
    }

    public function index(): HotelCollection
    {
        return new HotelCollection($this->hotelService->list());
    }

    public function store(StoreHotelRequest $request)
    {
        $hotel = $this->hotelService->create($request->validated());
        return (new HotelResource($hotel))
               ->response()
               ->setStatusCode(201);
    }

    public function show(Hotel $hotel): HotelResource
    {
        $hotel->load('asignaciones.tipoHabitacion','asignaciones.acomodacion');
        return new HotelResource($hotel);
    }

    public function update(UpdateHotelRequest $request, Hotel $hotel): HotelResource
    {
        return new HotelResource(
            $this->hotelService->update($hotel, $request->validated())
        );
    }

    public function destroy(Hotel $hotel)
    {
        $this->hotelService->delete($hotel);
        return response()->noContent();
    }
}
