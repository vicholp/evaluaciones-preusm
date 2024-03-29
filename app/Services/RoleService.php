<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Str;

/**
 * Responsible for managing user roles.
 */
class RoleService
{
    public const TEACHER = 'teacher';
    public const STUDENT = 'student';
    public const ADMIN = 'admin';

    public const ROLES = [
        self::ADMIN,
        self::STUDENT,
        self::TEACHER,
    ];

    public function __construct(
        private User $user
    ) {
        //
    }

    public function toString(): string
    {
        $roles = [];

        foreach (self::ROLES as $role) {
            if ($this->is($role)) {
                $roles[] = $role;
            }
        }

        return implode(', ', $roles);
    }

    public static function getRoles(): array
    {
        return self::ROLES;
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
        if ($this->is($role)) {
            return;
        }

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

        $this->user->refresh();
    }
}
