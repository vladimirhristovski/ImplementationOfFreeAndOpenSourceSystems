<?php

namespace App\Observers;

use App\Models\Enrollment;

class EnrollmentObserver
{
    public function creating(Enrollment $enrollment)
    {
        $enrollment->status = 'pending';
    }

    public function saved(Enrollment $enrollment)
    {
        $enrollment->course->touch();
    }
}
