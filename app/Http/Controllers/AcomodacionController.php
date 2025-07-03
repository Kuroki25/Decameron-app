<?php

namespace App\Http\Controllers;

use App\Models\Acomodacion;
use App\Http\Requests\StoreAcomodacionRequest;
use App\Http\Requests\UpdateAcomodacionRequest;
use App\Http\Resources\AcomodacionResource;

class AcomodacionController extends Controller
{
    public function index()
    {
        return AcomodacionResource::collection(Acomodacion::all());
    }

    public function store(StoreAcomodacionRequest $request)
    {
        $acomodacion = Acomodacion::create($request->validated());
        return new AcomodacionResource($acomodacion);
    }

    public function show(Acomodacion $acomodacion)
    {
        return new AcomodacionResource($acomodacion);
    }

    public function update(UpdateAcomodacionRequest $request, Acomodacion $acomodacion)
    {
        $acomodacion->update($request->validated());
        return new AcomodacionResource($acomodacion);
    }

    public function destroy(Acomodacion $acomodacion)
    {
        $acomodacion->delete();
        return response()->noContent();
    }
}