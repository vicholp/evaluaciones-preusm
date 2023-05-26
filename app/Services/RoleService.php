<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Str;

/**
 * Responsible for managing user roles.
 */
class RoleService
{
    public function __construct(
        private User $user
    ) {
        //
    }

    public function isAdmin(): bool
    {
        return $this->user->admin !== null;
    }

    public function isStudent(): bool
    {
        return $this->user->student !== null;
    }

    public function isTeacher(): bool
    {
        return $this->user->teacher !== null;
    }

    public function is(string $role): bool
    {
        return match ($role) {
            'admin' => $this->isAdmin(),
            'student' => $this->isStudent(),
            'teacher' => $this->isTeacher(),
            default => false,
        };
    }

    public function assign(string $role, array $attributes = []): void
    {
        switch ($role) {
            case 'admin':
                $this->user->admin()->create($attributes);
                break;
            case 'student':
                $attributes['uuid'] = Str::uuid();

                $this->user->student()->create($attributes);
                break;
            case 'teacher':
                $attributes['subject_id'] = 1;

                $this->user->teacher()->create($attributes);
                break;
        }
    }
}
