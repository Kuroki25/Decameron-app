<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreHotelRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre'               => 'required|string|max:255|unique:hotels,nombre,NULL,id,ciudad,' . $this->ciudad,
            'direccion'            => 'required|string|max:500',
            'ciudad'               => 'required|string|max:255',
            'nit'                  => 'required|string|max:50|unique:hotels,nit',
            'num_habitaciones_max' => 'required|integer|min:1',
        ];
    }
}

