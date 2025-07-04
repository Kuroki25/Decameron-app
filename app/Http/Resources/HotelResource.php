<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\HotelTipoAcomodacionResource;

class HotelResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'                   => $this->id,
            'nombre'               => $this->nombre,
            'direccion'            => $this->direccion,
            'ciudad'               => $this->ciudad,
            'nit'                  => $this->nit,
            'num_habitaciones_max' => $this->num_habitaciones_max,
            'asignaciones'         => HotelTipoAcomodacionResource::collection($this->whenLoaded('asignaciones')),
            'created_at'           => $this->created_at->toIso8601String(),
            'updated_at'           => $this->updated_at->toIso8601String(),
        ];
    }
}