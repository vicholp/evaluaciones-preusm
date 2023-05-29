<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UploadUsersRequest;
use App\Imports\Sheets\UsersImport;
use Illuminate\Http\RedirectResponse;
use Maatwebsite\Excel\Facades\Excel;

class UploadController extends Controller
{
    public function users(UploadUsersRequest $request): RedirectResponse
    {
        Excel::import(
            new UsersImport($request->role),
            $request->file('file') // @phpstan-ignore-line
        );

        return redirect()->route('filament.resources.users.index');
    }
}
