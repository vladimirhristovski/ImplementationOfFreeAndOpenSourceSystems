<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of courses
     */
    public function index(Request $request)
    {
        $query = Course::query();

        // search by title
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // filter by level (category)
        if ($request->filled('level')) {
            $query->where('level', $request->level);
        }

        $courses = $query->latest()->get();

        return view('courses.index', compact('courses'));
    }


    /**
     * Show the form for creating a new course
     */
    public function create()
    {
        return view('courses.create');
    }

    /**
     * Store a newly created course
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'summary' => 'required',
            'level' => 'required|in:beginner,intermediate,advanced',
            'start_date' => 'required|date',
            'seats' => 'required|integer|min:1'
        ]);

        Course::create($validated);

        return redirect()->route('courses.index')->with('success', 'Course created successfully!');
    }

    /**
     * Display the specified course
     */
    public function show(Course $course)
    {
        $course->load('enrollments');

        return view('courses.show', compact('course'));
    }

    /**
     * Show the form for editing the specified course
     */
    public function edit(Course $course)
    {
        return view('courses.edit', compact('course'));
    }

    /**
     * Update the specified course
     */
    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'title' => 'required',
            'summary' => 'required',
            'level' => 'required|in:beginner,intermediate,advanced',
            'start_date' => 'required|date',
            'seats' => 'required|integer|min:1'
        ]);

        $course->update($validated);

        return redirect()->route('courses.show', $course)->with('success', 'Course updated successfully!');
    }

    /**
     * Remove the specified course
     */
    public function destroy(Course $course)
    {
        $hasApprovedEnrollments = $course->enrollments()
            ->where('status', 'approved')
            ->exists();

        abort_if($hasApprovedEnrollments, 400, 'Cannot delete course with approved enrollments');

        $course->enrollments()->delete();
        $course->delete();

        return redirect()->route('courses.index')->with('success', 'Course deleted successfully!');
    }
}
