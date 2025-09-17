<?php

namespace App\Policies;

use App\Models\Incident;
use App\Models\User;
use App\Enums\UserRole;

class IncidentPolicy
{
    public function view(User $user, Incident $incident): bool
    {
        return $user->isAdmin() || $user->isResponder() || $incident->user_id === $user->id;
    }

    public function update(User $user, Incident $incident): bool
    {
        return $user->isAdmin() || $incident->user_id === $user->id;
    }

    public function comment(User $user, Incident $incident): bool
    {
        return $this->view($user, $incident);
    }

    public function manage(User $user): bool
    {
        return $user->role === UserRole::ADMIN;
    }
}
