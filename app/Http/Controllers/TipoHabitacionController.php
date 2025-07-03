<?php

namespace App\Http\Controllers;

use App\Models\TipoHabitacion;
use App\Http\Requests\StoreTipoHabitacionRequest;
use App\Http\Requests\UpdateTipoHabitacionRequest;
use App\Http\Resources\TipoHabitacionResource;

class TipoHabitacionController extends Controller
{
    public function index()
    {
        return TipoHabitacionResource::collection(TipoHabitacion::all());
    }

    public function store(StoreTipoHabitacionRequest $request)
    {
        $tipo = TipoHabitacion::create($request->validated());
        return new TipoHabitacionResource($tipo);
    }

    public function show(TipoHabitacion $tipoHabitacion)
    {
        return new TipoHabitacionResource($tipoHabitacion);
    }

    public function update(UpdateTipoHabitacionRequest $request, TipoHabitacion $tipoHabitacion)
    {
        $tipoHabitacion->update($request->validated());
        return new TipoHabitacionResource($tipoHabitacion);
    }

    public function destroy(TipoHabitacion $tipoHabitacion)
    {
        $tipoHabitacion->delete();
        return response()->noContent();
    }
}