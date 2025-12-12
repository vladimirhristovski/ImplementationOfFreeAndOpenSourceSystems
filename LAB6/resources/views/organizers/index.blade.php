@extends('layout')

@section('content')
    <h1>Organizers</h1>

    <form method="GET" action="{{ route('organizers.index') }}">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search...">
        <button type="submit">Search</button>
    </form>

    <a href="{{ route('organizers.create') }}">
        <button>Create Organizer</button>
    </a>

    <table border="1">
        <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($organizers as $organizer)
            <tr>
                <td>{{ $organizer->full_name }}</td>
                <td>{{ $organizer->email }}</td>
                <td>{{ $organizer->phone }}</td>
                <td>
                    <a href="{{ route('organizers.show', $organizer->id) }}">View</a>

                    <a href="{{ route('organizers.edit', $organizer->id) }}">Edit</a>

                    <form action="{{ route('organizers.destroy', $organizer->id) }}" method="POST"
                          style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                onclick="return confirm('Are you sure you want to delete this organizer?')">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div>
        {{ $organizers->links() }}
    </div>
@endsection
