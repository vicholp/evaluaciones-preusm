@extends('admin.template.main')

@section('content')
  <div class="container mx-auto grid grid-cols-12 p-3 gap-3 text-black text-opacity-90">
    <div class="col-span-12 flex flex-row items-center gap-3">
      <div class="font-medium text-lg p-2 rounded text-opacity-80 text-black items-center flex gap-3">
        @isset($user)
          <a href="{{ route('admin.users.show', $user) }}">
        @else
          <a href="{{ route('admin.users.index') }}">
        @endif
          <span class="iconify-inline text-xl" data-icon="mdi:arrow-left"></span>
        </a>
        <h3 class="">
          {{ $user->name ?? 'new user' }}
        </h3>
      </div>
      <div class="ml-auto"></div>
      <a  class="bg-gray-200 rounded p-3 text-black inline-block">
        Discard
      </a>
      <button form="form-user" type="submit" class="bg-blue-800 rounded p-3 text-white inline-block">
        Save
      </button>
    </div>
    @if ($errors->any())
      <div class="bg-red-200 p-3 col-span-12 rounded">
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif
    <div class="col-span-12 bg-white rounded shadow p-3 flex flex-col gap-3">
      @isset($user)
        <form action="{{ route('admin.users.update', $user) }}" method="POST" id="form-user">
        @method('PATCH')
      @else
          <form action="{{ route('admin.users.store') }}" method="POST" id="form-user">
      @endisset
        @csrf
        <div class="flex flex-col gap-4 p-3">
          <div class="grid grid-cols-12 items-center">
            <div class="col-span-4 text-black text-opacity-90"> name </div>
            <input type="text" class="col-span-8 rounded h-full" name="name" value="{{ $user->name ?? ''}}">
          </div>
          <div class="grid grid-cols-12 items-center">
            <div class="col-span-4 text-black text-opacity-90"> rut </div>
            <input type="text" class="col-span-8 rounded h-full" name="rut" value="{{ $user->rut ?? ''}}">
          </div>
          <div class="grid grid-cols-12 items-center">
            <div class="col-span-4 text-black text-opacity-90"> email </div>
            <input type="text" class="col-span-8 rounded h-full" name="email" value="{{ $user->email ?? '' }}">
          </div>
          <div class="grid grid-cols-12 items-center">
            <div class="col-span-4 text-black text-opacity-90"> password </div>
            <input type="password" class="col-span-8 rounded h-full" name="password" value="{{ $user->password ?? '' }}">
          </div>
        </div>
      </form>
    </div>
  </div>
@endsection
