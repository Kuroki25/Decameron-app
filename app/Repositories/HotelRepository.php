<?php
// app/Repositories/HotelRepository.php

namespace App\Repositories;

use App\Models\Hotel;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class HotelRepository implements HotelRepositoryInterface
{
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return Hotel::paginate($perPage);
    }

    public function create(array $data): Hotel
    {
        return Hotel::create($data);
    }

    public function update(Hotel $hotel, array $data): Hotel
    {
        $hotel->update($data);
        return $hotel;
    }

    public function delete(Hotel $hotel): void
    {
        $hotel->delete();
    }

    public function find(int $id): ?Hotel
    {
        return Hotel::find($id);
    }
}
