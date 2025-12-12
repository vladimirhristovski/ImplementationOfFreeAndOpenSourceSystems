@extends('layout')

@section('content')
    <h1>{{ $organizer->full_name }}'s Details</h1>

    <table border="1">
        <tr>
            <th>Name</th>
            <td>{{ $organizer->full_name }}</td>
        </tr>
        <tr>
            <th>Email</th>
            <td>{{ $organizer->email }}</td>
        </tr>
        <tr>
            <th>Phone</th>
            <td>{{ $organizer->phone }}</td>
        </tr>
    </table>

    <h2>Events</h2>
    <table border="1">
        <thead>
        <tr>
            <th>Name</th>
            <th>Description</th>
            <th>Type</th>
            <th>Date</th>
            <th>Amount</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($organizer->events as $event)
            <tr>
                <td>
                    <a href="{{ route('events.show', $event->id) }}">
                        {{ $event->name }}
                    </a>
                </td>
                <td>{{ $event->description }}</td>
                <td>{{ ucfirst($event->type) }}</td>
                <td>{{ $event->date }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <a href="{{ route('organizers.index') }}">Back to Organizers</a>
@endsection
