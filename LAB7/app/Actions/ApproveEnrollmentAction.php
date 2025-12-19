<?php

namespace App\Actions;

use App\Models\Enrollment;

class ApproveEnrollmentAction
{
    public function execute(Enrollment $enrollment)
    {
        abort_if($enrollment->status !== 'pending', 400, 'Only pending enrollments can be approved');

        $course = $enrollment->course;
        $course->seats -= $enrollment->seats_requested;
        $course->save();

        $enrollment->status = 'approved';
        $enrollment->save();

        return $enrollment;
    }
}
