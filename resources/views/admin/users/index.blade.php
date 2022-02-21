@extends('admin.template.main')

@section('content')
  <div class="container mx-auto grid grid-cols-12 p-3 gap-3">
    <div class="col-span-12 flex flex-row items-center gap-3">
      <div class="font-medium text-lg p-2 rounded inline-block text-opacity-80 text-black">
        users - {{ $users->count() }}
      </div>
      <div class="ml-auto"></div>
      <a href="{{ route('admin.users.upload') }}" class="bg-indigo-800 rounded p-3 text-white inline-block">
        Import
      </a>
      <a x-href="{{ route('admin.users.create') }}" class="bg-indigo-200 rounded p-3 text-white inline-block">
        Create
      </a>
    </div>
    <div class="col-span-12 flex flex-col divide-y card">
      <div class="grid grid-cols-12 px-6 py-3 text-black font-medium bg-black  bg-opacity-5 rounded">
        <div class="col-span-1">
          ID
        </div>
        <div class="col-span-7">
          Name
        </div>
        <div class="col-span-2">
          Email
        </div>
        <div class="col-span-2">
          Role
        </div>
      </div>
      <div class="p-3">
        @foreach ($users as $user)
        <a class="grid grid-cols-12 p-3" href="{{ route('admin.users.show', $user) }}">
          <div class="col-span-1">
            {{ $user->id }}
          </div>
          <div class="col-span-7">
            {{ $user->name }}
          </div>
          <div class="col-span-2">
            {{ $user->email }}
          </div>
          <div class="col-span-2">
            {{ $user->role ?? 'admin' }}
          </div>
        </a>
        @endforeach
      </div>
    </div>
  </div>
@endsection
