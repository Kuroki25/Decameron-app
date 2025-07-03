<?php
// app/Services/HotelServiceInterface.php

namespace App\Services;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Models\Hotel;

interface HotelServiceInterface
{
    public function list(int $perPage = 15): LengthAwarePaginator;
    public function create(array $data): Hotel;
    public function update(Hotel $hotel, array $data): Hotel;
    public function delete(Hotel $hotel): void;
    public function assignAccommodation(Hotel $hotel, array $data);
    public function removeAssignment(Hotel $hotel, int $assignmentId): void;
}
