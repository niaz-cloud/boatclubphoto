<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Student;

class StudentPolicy
{
    /**
     * View any students (list page)
     */
    public function viewAny(User $user)
    {
        // Admin & Super Admin can see all
        if ($user->hasRole(['Admin', 'Super Admin'])) {
            return true;
        }

        // Teacher can view list (but filtered in controller)
        if ($user->hasRole('Teacher')) {
            return true;
        }

        return false;
    }

    /**
     * View single student
     */
    public function view(User $user, Student $student)
    {
        // Admin & Super Admin can view all
        if ($user->hasRole(['Admin', 'Super Admin'])) {
            return true;
        }

        // Teacher can only view assigned students
        if ($user->hasRole('Teacher')) {
            return $student->teacher_id === $user->id;
        }

        return false;
    }

    /**
     * Update student
     */
    public function update(User $user, Student $student)
    {
        if ($user->hasRole(['Admin', 'Super Admin'])) {
            return true;
        }

        if ($user->hasRole('Teacher')) {
            return $student->teacher_id === $user->id;
        }

        return false;
    }

    /**
     * Delete student
     */
    public function delete(User $user, Student $student)
    {
        // Only Admin & Super Admin can delete
        return $user->hasRole(['Admin', 'Super Admin']);
    }
}
