<?php

use App\Models\Admin;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use App\Services\RoleService;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('has roles constant', function () {
    expect(RoleService::ROLES)->toBe([
        RoleService::ADMIN,
        RoleService::STUDENT,
        RoleService::TEACHER,
    ]);
});

test('is admin', function () {
    $admin = Admin::factory()->create();

    expect($admin->user->role()->isAdmin())->toBeTrue();
    expect($admin->user->role()->is(RoleService::ADMIN))->toBeTrue();
});

test('is student', function () {
    $student = Student::factory()->create();

    expect($student->user->role()->isStudent())->toBeTrue();
    expect($student->user->role()->is(RoleService::STUDENT))->toBeTrue();
});

test('is teacher', function () {
    $teacher = Teacher::factory()->create();

    expect($teacher->user->role()->isTeacher())->toBeTrue();
    expect($teacher->user->role()->is(RoleService::TEACHER))->toBeTrue();
});

test('to string', function () {
    $teacher = Teacher::factory()->create();

    expect($teacher->user->role()->toString())->toBe(RoleService::TEACHER);

    $student = Student::factory()->create();

    expect($student->user->role()->toString())->toBe(RoleService::STUDENT);

    $admin = Admin::factory()->create();

    expect($admin->user->role()->toString())->toBe(RoleService::ADMIN);

    $user = User::factory()->create();

    expect($user->role()->toString())->toBe('');
});

test('assign', function () {
    $user = User::factory()->create();

    $user->role()->assign(RoleService::ADMIN);

    expect($user->role()->isAdmin())->toBeTrue();

    $user->role()->assign(RoleService::STUDENT);

    expect($user->role()->isStudent())->toBeTrue();

    $user->role()->assign(RoleService::TEACHER);

    expect($user->role()->isTeacher())->toBeTrue();
});
