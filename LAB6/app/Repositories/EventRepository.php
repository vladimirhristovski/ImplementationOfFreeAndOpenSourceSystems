<?php

namespace App\Repositories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class EventRepository implements EventRepositoryInterface
{

    public function all(): Collection
    {
        return Event::all();
    }

    public function searchAndPaginate(?string $search, int $perPage = 10): LengthAwarePaginator
    {
        return Event::query()
            ->with('organizer')
            ->when($search, fn($q) => $q->where('name', 'like', "%$search%"))
            ->latest()
            ->paginate($perPage);
    }

    public function find(int $id): Event
    {
        return Event::query()->findOrFail($id);
    }

    public function create(array $data): Event
    {
        return Event::query()->create($data);
    }

    public function update(Event $event, array $data): Event
    {
        $event->update($data);

        return $event;
    }

    public function delete(Event $event): bool
    {
        return $event->delete();
    }
}
