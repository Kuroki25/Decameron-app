<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HotelTipoAcomodacionResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'                  => $this->id,
            'hotel_id'            => $this->hotel_id,
            'tipo_habitacion_id'  => $this->tipo_habitacion_id,
            'acomodacion_id'      => $this->acomodacion_id,
            'cantidad'            => $this->cantidad,
            'tipo'                => new TipoHabitacionResource($this->whenLoaded('tipoHabitacion')),
            'acomodacion'         => new AcomodacionResource($this->whenLoaded('acomodacion')),
        ];
    }
}
