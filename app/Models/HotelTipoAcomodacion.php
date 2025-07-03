<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HotelTipoAcomodacion extends Model
{
    protected $table = 'hotel_tipo_acomodacion';
    protected $fillable = [
        'hotel_id', 'tipo_habitacion_id', 'acomodacion_id', 'cantidad'
    ];

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function tipoHabitacion()
    {
        return $this->belongsTo(TipoHabitacion::class);
    }

    public function acomodacion()
    {
        return $this->belongsTo(Acomodacion::class);
    }
}