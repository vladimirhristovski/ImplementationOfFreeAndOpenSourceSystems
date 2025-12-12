<?php

namespace App\Http\Controllers;

use App\Http\Resources\EventResource;
use App\Http\Resources\OrganizerResource;
use App\Repositories\OrganizerRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class OrganizerController extends Controller
{
    protected OrganizerRepositoryInterface $organizerRepository;

    public function __construct(OrganizerRepositoryInterface $organizerRepository)
    {
        $this->organizerRepository = $organizerRepository;
    }

    public function index(Request $request): AnonymousResourceCollection
    {
        $organizers = $this->organizerRepository->searchAndPaginate(
            search: $request->get('search'),
            perPage: 10
        );

        return OrganizerResource::collection($organizers);
    }


    public function store(Request $request): OrganizerResource
    {
        $data = $request->all();
        $organizer = $this->organizerRepository->create($data);

        return OrganizerResource::make($organizer);
    }

    public function show(string $id): OrganizerResource
    {
        $organizer = $this->organizerRepository->find($id);

        return OrganizerResource::make($organizer);
    }

    public function update(Request $request, string $id): OrganizerResource
    {
        $data = $request->all();
        $organizer = $this->organizerRepository->find($id);
        $organizer = $this->organizerRepository->update($organizer, $data);

        return OrganizerResource::make($organizer);
    }

    public function destroy($id): JsonResponse
    {
        $organizer = $this->organizerRepository->find($id);
        $this->organizerRepository->delete($id);

        return response()->json(null, 204);
    }
}
