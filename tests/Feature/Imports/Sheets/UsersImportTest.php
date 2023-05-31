<?php

use App\Imports\Sheets\UsersImport;
use App\Models\User;
use App\Rules\ValidRut;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Maatwebsite\Excel\Facades\Excel;

uses(RefreshDatabase::class);

it('has validation', function () {

    $import = new UsersImport('student');

    expect($import->rules()['name'])->toBe(['required', 'string']);
    expect($import->rules()['email'])->toBe(['required', 'email']);

    expect($import->rules()['rut'][0])->toBe('required');
    expect($import->rules()['rut'][1])->toBe('string');
    expect($import->rules()['rut'][2])->toBeInstanceOf(ValidRut::class);

    expect($import->rules()['password'])->toBe(['sometimes', 'nullable', 'string']);
});

it('import users', function () {
    $users = User::factory()->count(3)->make();

    $usersCsv = $users->map(function ($u) {
        return collect([
            'name' => $u->name,
            'email' => $u->email,
            'rut' => $u->rut . '-' . $u->rut_dv,
        ])->implode('","');
    })->prepend('"name","email","rut')->implode("\"\n\"");

    $file = UploadedFile::fake()->createWithContent('users.csv', $usersCsv);

    Excel::import(
        new UsersImport('user'),
        $file
    );

    expect(User::count())->toBe(3);

    $databaseUsers = User::all();

    $users->each(function ($u) use ($databaseUsers) {
        $user = $databaseUsers->firstWhere('email', $u['email']);

        expect($user->name)->toBe($u['name']);
        expect($user->email)->toBe($u['email']);
        expect($user->rut)->toBe($u['rut']);
    });
});
