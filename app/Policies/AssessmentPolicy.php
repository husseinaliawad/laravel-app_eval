<?php

namespace App\Policies;

use App\Models\Assessment;
use App\Models\User;

class AssessmentPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('assessments.viewAny');
    }

    public function view(User $user, Assessment $assessment): bool
    {
        return $user->can('assessments.view');
    }

    public function create(User $user): bool
    {
        return $user->can('assessments.create');
    }

    public function update(User $user, Assessment $assessment): bool
    {
        return $user->can('assessments.update');
    }

    public function delete(User $user, Assessment $assessment): bool
    {
        return $user->can('assessments.delete');
    }
}
