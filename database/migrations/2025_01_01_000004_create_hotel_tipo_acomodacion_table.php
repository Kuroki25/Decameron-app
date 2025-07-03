<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /** Run the migrations. */
    public function up(): void
    {
        Schema::create('hotel_tipo_acomodacion', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hotel_id')
                  ->constrained('hotels')
                  ->onDelete('cascade');
            $table->foreignId('tipo_habitacion_id')
                  ->constrained('tipo_habitaciones')
                  ->onDelete('cascade');
            $table->foreignId('acomodacion_id')
                  ->constrained('acomodaciones')
                  ->onDelete('cascade');
            $table->unsignedInteger('cantidad');
            $table->timestamps();

            $table->unique(
                ['hotel_id','tipo_habitacion_id','acomodacion_id'],
                'hotel_tipo_unicidad'
            );
        });
    }

    /** Reverse the migrations. */
    public function down(): void
    {
        Schema::dropIfExists('hotel_tipo_acomodacion');
    }
};
