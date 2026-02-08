<?php

namespace App\Policies;

use App\Models\Kpi;
use App\Models\User;

class KpiPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('kpis.viewAny');
    }

    public function view(User $user, Kpi $kpi): bool
    {
        return $user->can('kpis.view');
    }

    public function create(User $user): bool
    {
        return $user->can('kpis.create');
    }

    public function update(User $user, Kpi $kpi): bool
    {
        return $user->can('kpis.update');
    }

    public function delete(User $user, Kpi $kpi): bool
    {
        return $user->can('kpis.delete');
    }
}
