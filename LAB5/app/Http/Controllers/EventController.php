<?php

namespace App\Http\Controllers;

use App\Http\Requests\Event\EventStoreRequest;
use App\Http\Requests\Event\EventUpdateRequest;
use App\Models\Organizer;
use App\Models\Event;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View|Factory|Application
    {
        $events = Event::query()
            ->with('organizer')
            ->when(
                $request->get('type') !== null,
                fn($query) => $query->where('type', $request->get('type'))
            )
            ->latest()
            ->paginate(10);

        return view('events/index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View|Factory|Application
    {
        $organizers = Organizer::query()
            ->get();

        return view('events/create', compact('organizers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EventStoreRequest $request): RedirectResponse
    {
        Event::query()
            ->create($request->validated());

        return redirect()
            ->route('events.index')
            ->with('success', 'Event created successfully.');

    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event): View|Factory|Application
    {
        $event->loadMissing('organizer');

        return view('events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event): View|Factory|Application
    {
        $organizers = Organizer::query()
            ->get();

        return view('events/edit', compact('event', 'organizers'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EventUpdateRequest $request, Event $event): RedirectResponse
    {
        $event->update($request->validated());

        return redirect()
            ->route('events.index')
            ->with('success', 'Event updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event): RedirectResponse
    {
        $event->delete();

        return redirect()
            ->route('events.index')
            ->with('success', 'Event deleted successfully.');

    }
}
