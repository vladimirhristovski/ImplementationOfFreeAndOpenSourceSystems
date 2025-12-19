@extends('layouts.app')

@section('title', 'Create New Course')

@section('content')
    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Create New Course</h1>

        <div class="bg-white rounded-lg shadow p-6">
            <form action="{{ route('courses.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="title" class="block text-gray-700 font-semibold mb-2">Title *</label>
                    <input
                        type="text"
                        name="title"
                        id="title"
                        value="{{ old('title') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 @error('title') border-red-500 @enderror"
                        required
                    >
                    @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="summary" class="block text-gray-700 font-semibold mb-2">Summary *</label>
                    <textarea
                        name="summary"
                        id="summary"
                        rows="4"
                        class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 @error('summary') border-red-500 @enderror"
                        required
                    >{{ old('summary') }}</textarea>
                    @error('summary')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="level" class="block text-gray-700 font-semibold mb-2">Level *</label>
                    <select
                        name="level"
                        id="level"
                        class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 @error('level') border-red-500 @enderror"
                        required
                    >
                        <option value="">Select Level</option>
                        <option value="beginner" {{ old('level') == 'beginner' ? 'selected' : '' }}>Beginner</option>
                        <option value="intermediate" {{ old('level') == 'intermediate' ? 'selected' : '' }}>
                            Intermediate
                        </option>
                        <option value="advanced" {{ old('level') == 'advanced' ? 'selected' : '' }}>Advanced</option>
                    </select>
                    @error('level')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="start_date" class="block text-gray-700 font-semibold mb-2">Start Date *</label>
                    <input
                        type="date"
                        name="start_date"
                        id="start_date"
                        value="{{ old('start_date') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 @error('start_date') border-red-500 @enderror"
                        required
                    >
                    @error('start_date')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="seats" class="block text-gray-700 font-semibold mb-2">Available Seats *</label>
                    <input
                        type="number"
                        name="seats"
                        id="seats"
                        value="{{ old('seats') }}"
                        min="1"
                        class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 @error('seats') border-red-500 @enderror"
                        required
                    >
                    @error('seats')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-4">
                    <button type="submit"
                            class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded font-semibold">
                        Create Course
                    </button>
                    <a href="{{ route('courses.index') }}"
                       class="flex-1 text-center bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded font-semibold">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
