<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Course Management')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
<nav class="bg-blue-600 text-white shadow-lg">
    <div class="container mx-auto px-4 py-4">
        <div class="flex items-center justify-between">
            <a href="{{ route('courses.index') }}" class="text-2xl font-bold">Course Management</a>
            <div class="space-x-4">
                <a href="{{ route('courses.index') }}" class="hover:text-blue-200">Courses</a>
                <a href="{{ route('courses.create') }}" class="hover:text-blue-200">Add Course</a>
                <a href="{{ route('enrollments.index') }}" class="hover:text-blue-200">Enrollments</a>
                <a href="{{ route('enrollments.create') }}" class="hover:text-blue-200">New Enrollment</a>
            </div>
        </div>
    </div>
</nav>

<main class="container mx-auto px-4 py-8">
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    @yield('content')
</main>

<footer class="bg-gray-800 text-white text-center py-4 mt-8">
    <p>&copy; 2024 Course Management System</p>
</footer>
</body>
</html>
