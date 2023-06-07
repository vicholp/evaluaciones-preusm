<?php

use App\Models\Admin;
use App\Models\Subject;
use App\Models\User;
use App\Services\RoleService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Maatwebsite\Excel\Facades\Excel;

uses(RefreshDatabase::class);

it('has show', function () {
    $admin = Admin::factory()->create();

    User::factory()->count(3)->create();

    $users = User::all();

    $this->actingAs($admin->user)
        ->get(route('admin.users.index'))
        ->assertOk()
        ->assertViewHas('users', $users);
});

it('has create', function () {
    $admin = Admin::factory()->create();

    $this->actingAs($admin->user)
        ->get(route('admin.users.create'))
        ->assertOk();
});

it('has store for users', function () {
    $request = makeUserForCreate();

    $admin = Admin::factory()->create();

    $this->actingAs($admin->user)
        ->post(route('admin.users.store'), $request)
        ->assertRedirect(route('admin.users.show', User::latest()->first()->id + 1));
});

it('has store for teachers', function () {
    $request = makeUserForCreate();

    $request['role'] = RoleService::TEACHER;
    $request['subject_id'] = Subject::inRandomOrder()->first()->id;

    $admin = Admin::factory()->create();

    $this->actingAs($admin->user)
        ->post(route('admin.users.store'), $request)
        ->assertRedirect(route('admin.users.show', User::latest()->first()->id + 1));
});

it('has store for students', function () {
    $request = makeUserForCreate();

    $request['role'] = RoleService::STUDENT;

    $admin = Admin::factory()->create();

    $this->actingAs($admin->user)
        ->post(route('admin.users.store'), $request)
        ->assertRedirect(route('admin.users.show', User::latest()->first()->id + 1));
});

it('has upload view', function () {
    $admin = Admin::factory()->create();

    $this->actingAs($admin->user)
        ->get(route('admin.users.upload'))
        ->assertOk();
});

it('can import', function () {
    Excel::fake();

    $users = User::factory()->count(3)->make();

    $users = $users->map(function ($u) {
        return collect([
            'name' => $u->name,
            'email' => $u->email,
            'rut' => $u->rut . '-' . $u->rut_dv,
        ])->implode('","');
    });

    $users = $users->prepend('"name","email","rut');
    $users = $users->implode("\"\n\"");
    $file = UploadedFile::fake()->createWithContent('users.csv', $users);

    $admin = Admin::factory()->create();

    $this->actingAs($admin->user)
        ->post(route('admin.users.import'), [
            'file' => $file,
            'role' => 'user',
        ])
        ->assertRedirect(route('admin.users.index'));

    Excel::assertImported('users.csv');
});

function makeUserForCreate()
{
    $user = User::factory()->make();

    return [
        'name' => $user->name,
        'email' => $user->email,
        'rut' => $user->rut . '-' . $user->rut_dv,
        'password' => $user->rut,
    ];
}
