@extends('layouts.app')

@section('title', 'Create Enrollment')

@section('content')
    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Create New Enrollment</h1>

        <div class="bg-white rounded-lg shadow p-6">
            <form action="{{ route('enrollments.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="course_id" class="block text-gray-700 font-semibold mb-2">Select Course *</label>
                    <select
                        name="course_id"
                        id="course_id"
                        class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 @error('course_id') border-red-500 @enderror"
                        required
                    >
                        <option value="">Choose a course</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                                {{ $course->title }} ({{ $course->seats }} seats available)
                            </option>
                        @endforeach
                    </select>
                    @error('course_id')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="student_name" class="block text-gray-700 font-semibold mb-2">Student Name *</label>
                    <input
                        type="text"
                        name="student_name"
                        id="student_name"
                        value="{{ old('student_name') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 @error('student_name') border-red-500 @enderror"
                        required
                    >
                    @error('student_name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="seats_requested" class="block text-gray-700 font-semibold mb-2">Seats Requested
                        *</label>
                    <input
                        type="number"
                        name="seats_requested"
                        id="seats_requested"
                        value="{{ old('seats_requested', 1) }}"
                        min="1"
                        class="w-full px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 @error('seats_requested') border-red-500 @enderror"
                        required
                    >
                    @error('seats_requested')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex gap-4">
                    <button type="submit"
                            class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded font-semibold">
                        Create Enrollment
                    </button>
                    <a href="{{ route('enrollments.index') }}"
                       class="flex-1 text-center bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded font-semibold">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
