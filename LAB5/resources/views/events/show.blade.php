<h1>Event Details</h1>

<div>
    <strong>Name:</strong> {{ $event->name }}
</div>
<div>
    <strong>Description:</strong> {{ $event->description }}
</div>
<div>
    <strong>Type:</strong> {{ ucfirst($event->type) }}
</div>
<div>
    <strong>Organizer:</strong>
    <a href="{{ route('organizers.show', $event->organizer->id) }}">
        {{ $event->organizer->full_name }}
    </a>
</div>

<div>
    <strong>Date:</strong> {{ $event->date }}
</div>

<a href="{{ route('events.index') }}">Back to Events</a>
