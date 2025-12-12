<?php

namespace App\Repositories;

use App\Models\Organizer;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class OrganizerRepository implements OrganizerRepositoryInterface
{

    public function all(): Collection
    {
        return Organizer::all();
    }

    public function searchAndPaginate(?string $search, int $perPage = 10): LengthAwarePaginator
    {
        return Organizer::query()
            ->when($search, fn($query) =>
            $query->where('full_name', 'like', "%{$search}%")
            )
            ->latest()
            ->paginate($perPage);
    }



    public function find(int $id): Organizer
    {
        return Organizer::query()->findOrFail($id);
    }

    public function create(array $data): Organizer
    {
        return Organizer::query()->create($data);
    }

    public function update(Organizer $organizer, array $data): Organizer
    {
        $organizer->update($data);

        return $organizer;
    }

    public function delete(Organizer $organizer): bool
    {
        return $organizer->delete();
    }
}
