<?php

namespace App\Policies;

use App\Models\User;
use App\Models\WorkedPeriod;

class WorkedPeriodPolicy
{
    public function update(User $user, WorkedPeriod $period): bool
    {
        return $period->user_id === $user->id;
    }

    public function destroy(User $user, WorkedPeriod $period): bool
    {
        return $period->user_id === $user->id;
    }
}
