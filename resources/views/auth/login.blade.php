@extends('auth.template.main')

@section('title', __('log in'))

@section('content')
  <div class="container mx-auto grid grid-cols-12 p-3 gap-3 text-black text-opacity-90 h-screen">
    <div class="col-span-12 flex flex-col gap-3 mx-auto w-max h-max my-auto">
      @if ($errors->any())
        <div class="flex  bg-red-500 rounded shadow-red p-4 text-white">
          <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif
      <div class="flex bg-white p-5 rounded shadow-lg flex-col items-center">
        <form action="/login" method="POST" class="flex flex-col gap-5">
          @csrf
          <h2 class="text-lg text-center py-3">
            Evaluaciones Preusm
          </h2>
          <input class="bg-white border border-black border-opacity-25 py-3 rounded px-4" type="email" name="email" placeholder="{{ __('email') }}" required>
          <input class="bg-white border border-black border-opacity-25 py-3 rounded px-4" type="password" name="password" placeholder="{{ __('password') }}" required>

          <button class="bg-indigo-800 p-3 px-6 text-white rounded mt-5">{{ __('log in') }}</button>
        </form>
      </div>
    </div>
  </div>
@endsection
