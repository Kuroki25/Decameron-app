<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AcomodacionResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'     => $this->id,
            'nombre' => $this->nombre,
        ];
    }
}
