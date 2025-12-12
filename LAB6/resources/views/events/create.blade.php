<h1>Create New Event</h1>

<form method="POST" action="{{ route('events.store') }}">
    @csrf
    <div>
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" value="{{ old('name') }}">
        @error('name')
        <div style="color: red;">{{ $message }}</div>
        @enderror
    </div>

    <div>
        <label for="description">Description:</label>
        <input type="text" name="description" id="description" value="{{ old('description') }}">
        @error('description')
        <div style="color: red;">{{ $message }}</div>
        @enderror
    </div>

    <div>
        <label for="type">Type:</label>
        <select name="type" id="type">
            @foreach(\App\Enums\EventTypeEnum::cases() as $type)
                <option value="{{ $type->value }}" {{ old('type') == $type->value ? 'selected' : '' }}>
                    {{ ucfirst($type->value) }}
                </option>
            @endforeach
        </select>
        @error('type')
        <div style="color: red;">{{ $message }}</div>
        @enderror
    </div>

    <div>
        <label for="organizer_id">Organizer:</label>
        <select name="organizer_id" id="organizer_id">
            <option value="">Select Organizer</option>
            @foreach ($organizers as $organizer)
                <option value="{{ $organizer->id }}" {{ old('organizer_id') == $organizer->id ? 'selected' : '' }}>
                    {{ $organizer->full_name }}
                </option>
            @endforeach
        </select>
        @error('organizer_id')
        <div style="color: red;">{{ $message }}</div>
        @enderror
    </div>

    <div>
        <label for="date">Date:</label>
        <input type="date" name="date" id="date" value="{{ old('date') }}">
        @error('date')
        <div style="color: red;">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit">Create Event</button>
</form>

<a href="{{ route('events.index') }}">Back to Events</a>
