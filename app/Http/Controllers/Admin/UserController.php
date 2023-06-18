<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ImportUsersRequest;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Imports\Sheets\UsersImport;
use App\Models\Subject;
use App\Models\User;
use App\Services\RoleService;
use App\Utils\Rut;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('admin.users.index', [
            'users' => User::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $subjects = Subject::get();
        $roles = RoleService::getRoles();

        return view('admin.users.create', [
            'subjects' => $subjects,
            'roles' => $roles,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        $rut = Rut::fromString($request->rut);

        $user = User::create([
            ...$request->safe()->only('name', 'email'),
            'password' => Hash::make($request->password),
            'rut' => $rut->getRut(),
            'rut_dv' => $rut->getDv(),
        ]);

        if ($request->role) {
            $user->role()->assign($request->role);
        }

        return redirect()->route('admin.users.show', $user);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): View
    {
        return view('admin.users.show', [
            'user' => $user,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): View
    {
        return view('admin.users.edit', [
            'user' => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user): void
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): void
    {
        //
    }

    public function upload(): View
    {
        $roles = RoleService::getRoles();

        return view('admin.users.upload', [
            'roles' => $roles,
        ]);
    }

    public function import(ImportUsersRequest $request): RedirectResponse
    {
        Excel::import(
            new UsersImport($request->role),
            $request->file('file') // @phpstan-ignore-line
        );

        return redirect()->route('admin.users.index');
    }
}
