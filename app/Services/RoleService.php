<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;

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
        try {
            switch ($role) {
                case 'admin':
                    $this->user->admin()->create($attributes);
                    break;
                case 'student':
                    $attributes['uuid'] = Str::uuid();

                    $this->user->student()->create($attributes);
                    break;
                case 'teacher':
                    $this->user->teacher()->create($attributes);
                    break;
            }
        } catch (QueryException $e) {
            // Ignore
        }
    }
}
