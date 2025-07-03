<?php
// app/Repositories/HotelRepositoryInterface.php

namespace App\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Models\Hotel;

interface HotelRepositoryInterface
{
    public function paginate(int $perPage = 15): LengthAwarePaginator;
    public function create(array $data): Hotel;
    public function update(Hotel $hotel, array $data): Hotel;
    public function delete(Hotel $hotel): void;
    public function find(int $id): ?Hotel;
}
