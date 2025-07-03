<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Acomodacion extends Model
{
    protected $table = 'acomodaciones';
    protected $fillable = ['nombre'];

    public function hoteles()
    {
        return $this->belongsToMany(
            Hotel::class,
            'hotel_tipo_acomodacion'
        )
        ->withPivot('tipo_habitacion_id','cantidad')
        ->withTimestamps();
    }
}