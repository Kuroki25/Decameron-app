<?php
// app/Http/Requests/StoreHotelTipoAcomodacionRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\ValidAccommodationForType;

class StoreHotelTipoAcomodacionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $hotel = $this->route('hotel');
        $typeId = (int) $this->input('tipo_habitacion_id');

        return [
            'tipo_habitacion_id' => ['required','exists:tipo_habitaciones,id'],
            'acomodacion_id'     => [
                'required','exists:acomodaciones,id',
                new ValidAccommodationForType($typeId)
            ],
            'cantidad'           => "required|integer|min:1|max:{$hotel->num_habitaciones_max}",
        ];
    }
}
