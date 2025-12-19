<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\Course;
use App\Actions\ApproveEnrollmentAction;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    /**
     * Display all enrollments
     */
    public function index(Request $request)
    {
        $query = Enrollment::with('course')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $enrollments = $query->get();

        return view('enrollments.index', compact('enrollments'));
    }

    /**
     * Show the form for creating a new enrollment
     */
    public function create()
    {
        $courses = Course::where('seats', '>', 0)->get();

        return view('enrollments.create', compact('courses'));
    }

    /**
     * Store a new enrollment
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'student_name' => 'required',
            'seats_requested' => 'required|integer|min:1'
        ]);

        $enrollment = Enrollment::create($validated);

        // If request came from course page, redirect back there
        if ($request->has('from_course')) {
            return redirect()
                ->route('courses.show', $enrollment->course_id)
                ->with('success', 'Enrollment created successfully! Status: Pending');
        }

        // Otherwise redirect to enrollments list
        return redirect()
            ->route('enrollments.index')
            ->with('success', 'Enrollment created successfully! Status: Pending');
    }

    /**
     * Approve an enrollment
     */
    public function approve(Enrollment $enrollment, ApproveEnrollmentAction $action)
    {
        try {
            $action->execute($enrollment);

            return redirect()
                ->back()
                ->with('success', 'Enrollment approved successfully!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Drop (cancel) an enrollment
     */
    public function drop(Enrollment $enrollment)
    {
        abort_if($enrollment->status !== 'approved', 400, 'Only approved enrollments can be dropped');

        $enrollment->status = 'dropped';
        $enrollment->save();

        return redirect()
            ->back()
            ->with('success', 'Enrollment dropped successfully!');
    }
}
