<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    protected $fillable = [
        'nombre', 'direccion', 'ciudad', 'nit', 'num_habitaciones_max'
    ];

    public function asignaciones()
    {
        return $this->hasMany(HotelTipoAcomodacion::class);
    }

    public function tipos()
    {
        return $this->belongsToMany(
            TipoHabitacion::class,
            'hotel_tipo_acomodacion'
        )
        ->withPivot('acomodacion_id','cantidad')
        ->withTimestamps();
    }

    public function acomodaciones()
    {
        return $this->belongsToMany(
            Acomodacion::class,
            'hotel_tipo_acomodacion'
        )
        ->withPivot('tipo_habitacion_id','cantidad')
        ->withTimestamps();
    }
}

