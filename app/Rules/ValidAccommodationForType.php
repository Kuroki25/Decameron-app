<?php
// app/Rules/ValidAccommodationForType.php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\TipoHabitacion;
use App\Models\Acomodacion;

class ValidAccommodationForType implements Rule
{
    protected int $roomTypeId;
    protected string $messageType;

    /**
     * @param  int  $roomTypeId
     */
    public function __construct(int $roomTypeId)
    {
        $this->roomTypeId = $roomTypeId;
    }

    /**
     * Verifica si la acomodación es válida para el tipo de habitación.
     *
     * @param  string  $attribute
     * @param  mixed   $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        $type = TipoHabitacion::find($this->roomTypeId);
        $acom = Acomodacion::find($value);

        if (! $type || ! $acom) {
            $this->messageType = 'Tipo de habitación o acomodación inválido.';
            return false;
        }

        $mapping = [
            'Estándar' => ['Sencilla','Doble'],
            'Junior'   => ['Triple','Cuádruple'],
            'Suite'    => ['Sencilla','Doble','Triple'],
        ];

        $allowed = $mapping[$type->nombre] ?? [];

        if (! in_array($acom->nombre, $allowed, true)) {
            $this->messageType = "Para '{$type->nombre}' sólo puede usar: ".implode(', ',$allowed).'.';
            return false;
        }

        return true;
    }

    /**
     * Mensaje de error personalizado.
     *
     * @return string
     */
    public function message(): string
    {
        return $this->messageType;
    }
}
