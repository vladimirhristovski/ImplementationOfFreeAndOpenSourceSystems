<h1>Edit Event</h1>

<form method="POST" action="{{ route('events.update', $event) }}">
    @csrf
    @method('PUT')

    <div>
        <label for="name">Name:</label>
        <input type="text" name="name" id="name"
               value="{{ old('name', $event->name) }}">
        @error('name')
        <div style="color: red;">{{ $message }}</div>
        @enderror
    </div>

    <div>
        <label for="description">Description:</label>
        <input type="text" name="description" id="description"
               value="{{ old('description', $event->description) }}">
        @error('description')
        <div style="color: red;">{{ $message }}</div>
        @enderror
    </div>

    <div>
        <label for="type">Type:</label>
        <select name="type" id="type">
            @foreach(\App\Enums\EventTypeEnum::cases() as $type)
                <option
                    value="{{ $type->value }}" {{ old('type', $event->type) == $type->value ? 'selected' : '' }}>
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
            @foreach ($organizers as $organizer)
                <option
                    value="{{ $organizer->id }}" {{ old('organizer_id', $event->organizer_id) == $organizer->id ? 'selected' : '' }}>
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
        <input type="date" name="date" id="date" value="{{ old('date', $event->date) }}">
        @error('date')
        <div style="color: red;">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit">Update Event</button>
</form>

<a href="{{ route('events.index') }}">Back to Events</a>
