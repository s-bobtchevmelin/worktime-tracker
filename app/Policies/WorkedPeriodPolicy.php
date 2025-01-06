<?php

namespace App\Policies;

use App\Models\User;
use App\Models\WorkedPeriod;

class WorkedPeriodPolicy
{
    public function destroy(User $user, WorkedPeriod $period): bool
    {
        return $period->user_id === $user->id;
    }
}
