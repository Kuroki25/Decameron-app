<?php
// app/Services/HotelService.php

namespace App\Services;

use App\Repositories\HotelRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Models\Hotel;

class HotelService implements HotelServiceInterface
{
    private HotelRepositoryInterface $repo;

    /**
     * @param  HotelRepositoryInterface  $repo
     */
    public function __construct(HotelRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function list(int $perPage = 15): LengthAwarePaginator
    {
        return $this->repo->paginate($perPage);
    }

    public function create(array $data): Hotel
    {
        return $this->repo->create($data);
    }

    public function update(Hotel $hotel, array $data): Hotel
    {
        return $this->repo->update($hotel, $data);
    }

    public function delete(Hotel $hotel): void
    {
        $this->repo->delete($hotel);
    }

    public function assignAccommodation(Hotel $hotel, array $data)
    {
        return $hotel->asignaciones()->create($data);
    }

    public function removeAssignment(Hotel $hotel, int $assignmentId): void
    {
        $hotel->asignaciones()->findOrFail($assignmentId)->delete();
    }
}
