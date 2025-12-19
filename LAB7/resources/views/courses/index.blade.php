@extends('layouts.app')

@section('title', 'All Courses')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">All Courses</h1>
        <a href="{{ route('courses.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded">
            Add New Course
        </a>
    </div>

    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <form method="GET" action="{{ route('courses.index') }}" class="flex gap-4">
            <input
                type="text"
                name="search"
                placeholder="Search courses..."
                value="{{ request('search') }}"
                class="flex-1 px-4 py-2 border border-gray-300 rounded"
            >

            <select name="level"
                    class="px-4 py-2 border border-gray-300 rounded">
                <option value="">All levels</option>
                <option value="beginner" {{ request('level') === 'beginner' ? 'selected' : '' }}>Beginner</option>
                <option value="intermediate" {{ request('level') === 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                <option value="advanced" {{ request('level') === 'advanced' ? 'selected' : '' }}>Advanced</option>
            </select>

            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded">
                Search
            </button>

            @if(request('search') || request('level'))
                <a href="{{ route('courses.index') }}"
                   class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded">
                    Clear
                </a>
            @endif
        </form>

    </div>

    @if($courses->isEmpty())
        <div class="bg-white rounded-lg shadow p-8 text-center">
            <p class="text-gray-500 text-lg">No courses found.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($courses as $course)
                <div class="bg-white rounded-lg shadow hover:shadow-lg transition">
                    <div class="p-6">
                        <h2 class="text-xl font-bold text-gray-800 mb-2">{{ $course->title }}</h2>

                        <div class="space-y-2 mb-4">
                            <p class="text-sm text-gray-600">
                                <span class="font-semibold">Level:</span>
                                <span class="inline-block px-2 py-1 rounded text-xs
                                @if($course->level === 'beginner') bg-green-100 text-green-800
                                @elseif($course->level === 'intermediate') bg-yellow-100 text-yellow-800
                                @else bg-red-100 text-red-800
                                @endif">
                                {{ ucfirst($course->level) }}
                            </span>
                            </p>
                            <p class="text-sm text-gray-600">
                                <span
                                    class="font-semibold">Start Date:</span> {{ $course->start_date->format('M d, Y') }}
                            </p>
                            <p class="text-sm text-gray-600">
                                <span class="font-semibold">Available Seats:</span> {{ $course->seats }}
                            </p>
                        </div>

                        <div class="flex gap-2">
                            <a href="{{ route('courses.show', $course) }}"
                               class="flex-1 text-center bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm">
                                View
                            </a>
                            <a href="{{ route('courses.edit', $course) }}"
                               class="flex-1 text-center bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded text-sm">
                                Edit
                            </a>
                            <form action="{{ route('courses.destroy', $course) }}" method="POST"
                                  onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded text-sm">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
@endsection
