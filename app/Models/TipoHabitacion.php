<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoHabitacion extends Model
{
    protected $table = 'tipo_habitaciones';
    protected $fillable = ['nombre'];

    public function hoteles()
    {
        return $this->belongsToMany(
            Hotel::class,
            'hotel_tipo_acomodacion'
        )
        ->withPivot('acomodacion_id','cantidad')
        ->withTimestamps();
    }
}