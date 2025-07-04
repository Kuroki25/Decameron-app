<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHotelRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $hotelId = $this->route('hotel')->id;
        return [
            'nombre'               => "required|string|max:255|unique:hotels,nombre,{$hotelId},id,ciudad,{$this->ciudad}",
            'direccion'            => 'sometimes|required|string|max:500',
            'ciudad'               => 'sometimes|required|string|max:255',
            'nit'                  => "required|string|max:50|unique:hotels,nit,{$hotelId}",
            'num_habitaciones_max' => 'sometimes|required|integer|min:1',
        ];
    }
}
    
