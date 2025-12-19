@extends('layouts.app')

@section('title', $course->title)

@section('content')
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">{{ $course->title }}</h1>
            <div class="flex gap-2">
                <a href="{{ route('courses.edit', $course) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded">
                    Edit
                </a>
                <form action="{{ route('courses.destroy', $course) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">
                        Delete
                    </button>
                </form>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-sm font-semibold text-gray-600 mb-1">Level</h3>
                    <span class="inline-block px-3 py-1 rounded
                    @if($course->level === 'beginner') bg-green-100 text-green-800
                    @elseif($course->level === 'intermediate') bg-yellow-100 text-yellow-800
                    @else bg-red-100 text-red-800
                    @endif">
                    {{ ucfirst($course->level) }}
                </span>
                </div>

                <div>
                    <h3 class="text-sm font-semibold text-gray-600 mb-1">Start Date</h3>
                    <p class="text-gray-800">{{ $course->start_date->format('F d, Y') }}</p>
                </div>

                <div>
                    <h3 class="text-sm font-semibold text-gray-600 mb-1">Available Seats</h3>
                    <p class="text-gray-800 text-2xl font-bold">{{ $course->seats }}</p>
                </div>

                <div>
                    <h3 class="text-sm font-semibold text-gray-600 mb-1">Total Enrollments</h3>
                    <p class="text-gray-800 text-2xl font-bold">{{ $course->enrollments->count() }}</p>
                </div>
            </div>

            <div class="mt-6">
                <h3 class="text-sm font-semibold text-gray-600 mb-2">Summary</h3>
                <p class="text-gray-800 leading-relaxed">{{ $course->summary }}</p>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-2xl font-bold text-gray-800">Enroll Student</h2>
            </div>

            <form action="{{ route('enrollments.store') }}" method="POST" class="flex gap-4">
                @csrf
                <input type="hidden" name="course_id" value="{{ $course->id }}">
                <input type="hidden" name="from_course" value="1">

                <input
                    type="text"
                    name="student_name"
                    placeholder="Student Name"
                    value="{{ old('student_name') }}"
                    class="flex-1 px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 @error('student_name') border-red-500 @enderror"
                    required
                >

                <input
                    type="number"
                    name="seats_requested"
                    placeholder="Seats"
                    value="{{ old('seats_requested', 1) }}"
                    min="1"
                    class="w-24 px-4 py-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 @error('seats_requested') border-red-500 @enderror"
                    required
                >

                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded">
                    Enroll
                </button>
            </form>

            @error('student_name')
            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
            @enderror
            @error('seats_requested')
            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Enrollments ({{ $course->enrollments->count() }})</h2>

            @if($course->enrollments->isEmpty())
                <p class="text-gray-500 text-center py-4">No enrollments yet.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Student Name</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Seats</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Date</th>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Actions</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y">
                        @foreach($course->enrollments as $enrollment)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3">{{ $enrollment->student_name }}</td>
                                <td class="px-4 py-3">{{ $enrollment->seats_requested }}</td>
                                <td class="px-4 py-3">
                                    <span class="inline-block px-2 py-1 rounded text-xs
                                        @if($enrollment->status === 'pending') bg-yellow-100 text-yellow-800
                                        @elseif($enrollment->status === 'approved') bg-green-100 text-green-800
                                        @else bg-gray-100 text-gray-800
                                        @endif">
                                        {{ ucfirst($enrollment->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">{{ $enrollment->created_at->format('M d, Y') }}</td>
                                <td class="px-4 py-3">
                                    @if($enrollment->status === 'pending')
                                        <form action="{{ route('enrollments.approve', $enrollment) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="text-green-600 hover:text-green-800 font-semibold text-sm">
                                                Approve
                                            </button>
                                        </form>
                                    @elseif($enrollment->status === 'approved')
                                        <form action="{{ route('enrollments.drop', $enrollment) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="text-red-600 hover:text-red-800 font-semibold text-sm" onclick="return confirm('Are you sure?')">
                                                Drop
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <div class="mt-6">
            <a href="{{ route('courses.index') }}" class="text-blue-600 hover:text-blue-800">
                ← Back to Courses
            </a>
        </div>
    </div>
@endsection
