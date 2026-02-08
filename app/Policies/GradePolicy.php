<?php

namespace App\Policies;

use App\Models\Grade;
use App\Models\User;

class GradePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('grades.viewAny');
    }

    public function view(User $user, Grade $grade): bool
    {
        return $user->can('grades.view');
    }

    public function create(User $user): bool
    {
        return $user->can('grades.create');
    }

    public function update(User $user, Grade $grade): bool
    {
        return $user->can('grades.update');
    }

    public function delete(User $user, Grade $grade): bool
    {
        return $user->can('grades.delete');
    }
}
