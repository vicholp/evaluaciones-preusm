<?php

use App\Models\Admin;
use App\Models\User;
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
            'role' => 'student'
        ])
        ->assertRedirect(route('admin.users.index'));

    Excel::assertImported('users.csv');
});
