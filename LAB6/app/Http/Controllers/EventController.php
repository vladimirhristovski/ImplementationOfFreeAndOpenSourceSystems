<?php

namespace App\Http\Controllers;

use App\Http\Resources\EventResource;
use App\Repositories\EventRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class EventController extends Controller
{
    protected EventRepositoryInterface $eventRepository;

    public function __construct(EventRepositoryInterface $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    public function index(Request $request): AnonymousResourceCollection
    {
        $events = $this->eventRepository->searchAndPaginate(
            search: $request->get('search'),
            perPage: 10
        );

        return EventResource::collection($events);
    }


    public function store(Request $request): EventResource
    {
        $data = $request->all();
        $event = $this->eventRepository->create($data);

        return EventResource::make($event);
    }

    public function show(string $id): EventResource
    {
        $event = $this->eventRepository->find($id);

        return EventResource::make($event);
    }

    public function update(Request $request, string $id): EventResource
    {
        $data = $request->all();
        $event = $this->eventRepository->find($id);
        $event = $this->eventRepository->update($event, $data);

        return EventResource::make($event);
    }

    public function destroy($id): JsonResponse
    {
        $event = $this->eventRepository->find($id);
        $this->eventRepository->delete($id);

        return response()->json(null, 204);
    }
}
