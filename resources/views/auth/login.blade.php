@extends('auth.template.main')
@section('content')
<div class="container mx-auto mt-40 grid grid-cols-12 gap-3 justify-center">
  <div class="col-span-4 col-start-5 grid grid-cols-12 gap-3">
    @if ($errors->any())
    <div class="flex col-span-12 bg-red-500 rounded shadow-red p-4 text-white">
      <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif
    <div class="flex col-span-12 bg-white rounded shadow-lg py-6 flex-col items-center">
      <form action="{{ route('auth.authenticate') }}" method="POST">
        @csrf
        <button type="submit" class="p-4 font-medium">
          Log in
        </button>
        <div class="mt-4">
          <input class="bg-white border rounded p-2" type="email" name="email" placeholder="Email" required>
        </div>
        <div class="mt-4">
          <input class="bg-white border rounded p-2" type="password" name="password" placeholder="Password" required>
        </div>
        <div class="mt-4">
          <button class="bg-indigo-800 p-3 px-6 text-white rounded">Log in</button>
        </div>
      </form>
    </div>
  </div>
  </div>
@endsection
