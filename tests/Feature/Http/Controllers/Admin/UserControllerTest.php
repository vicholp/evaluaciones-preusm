<?php

use App\Models\Admin;
use App\Models\Subject;
use App\Models\User;
use App\Services\RoleService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

uses(RefreshDatabase::class);

it('has show', function () {
    $admin = Admin::factory()->create();

    User::factory()->count(3)->create();

    $users = User::all();

    $this->actingAs($admin->user)
        ->get(route('admin.users.index'))
        ->assertOk()
        ->assertViewIs('admin.users.index')
        ->assertViewHas('users', $users);
});

it('has create', function () {
    $admin = Admin::factory()->create();

    $this->actingAs($admin->user)
        ->get(route('admin.users.create'))
        ->assertOk()
        ->assertViewIs('admin.users.create');
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

    $response = $this->actingAs($admin->user)
        ->post(route('admin.users.store'), $request)
        ->assertRedirect()
        ->assertSessionHasNoErrors();

    $this->followRedirects($response)
        ->assertViewIs('admin.users.show');
});

it('has store for students', function () {
    $request = makeUserForCreate();

    $request['role'] = RoleService::STUDENT;

    $admin = Admin::factory()->create();

    $response = $this->actingAs($admin->user)
        ->post(route('admin.users.store'), $request)
        ->assertRedirect()
        ->assertSessionHasNoErrors();

    $this->followRedirects($response)
        ->assertViewIs('admin.users.show');
});

it('has upload view', function () {
    $admin = Admin::factory()->create();

    $this->actingAs($admin->user)
        ->get(route('admin.users.upload'))
        ->assertOk()
        ->assertViewIs('admin.users.upload');
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

it('has edit', function () {
    $user = User::factory()->create();

    $admin = Admin::factory()->create();

    $this->actingAs($admin->user)
        ->get(route('admin.users.edit', $user))
        ->assertOk()
        ->assertViewIs('admin.users.edit')
        ->assertViewHas('user', $user);
});

it('has update', function () {
    $user = User::factory()->create();

    $admin = Admin::factory()->create();

    $this->actingAs($admin->user)
        ->put(route('admin.users.update', $user), [
            'name' => 'New Name',
            'email' => 'newmail@mail.cl',
            'password' => 'newpassword',
        ])
        ->assertRedirect(route('admin.users.show', $user));

    $user->refresh();

    expect($user->name)->toBe('New Name');
    expect($user->email)->toBe('newmail@mail.cl');
    expect(Hash::check('newpassword', $user->password))->toBeTrue();
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
