<?php
// app/Http/Controllers/HotelTipoAcomodacionController.php

namespace App\Http\Controllers;

use App\Http\Requests\StoreHotelTipoAcomodacionRequest;
use App\Http\Resources\HotelTipoAcomodacionResource;
use App\Services\HotelServiceInterface;
use App\Models\Hotel;

class HotelTipoAcomodacionController extends Controller
{
    private HotelServiceInterface $hotelService;

    public function __construct(HotelServiceInterface $hotelService)
    {
        $this->hotelService = $hotelService;
    }

    public function store(StoreHotelTipoAcomodacionRequest $request, Hotel $hotel)
    {
        $pivot = $this->hotelService->assignAccommodation($hotel, $request->validated());
        return new HotelTipoAcomodacionResource($pivot);
    }

    public function destroy(Hotel $hotel, $asignacionId)
    {
        $this->hotelService->removeAssignment($hotel, $asignacionId);
        return response()->noContent();
    }
}
