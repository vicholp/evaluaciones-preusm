@extends('auth.template.main')

@section('title', __('log in'))

@section('content')
  <x-base.layout.container class="mx-auto h-screen w-96">
    <div class="col-span-12">
      <x-base.form.errors />
    </div>
    <div class="col-span-12">
      <x-base.card>
        <form
          action="/login"
          method="POST"
          class="flex flex-col gap-5"
        >
          @csrf
          <h2 class="py-3 text-center text-lg">
            Evaluaciones Preusm
          </h2>
          <x-base.form.input-text
            type="email"
            name="email"
            placeholder="{{ __('email') }}"
            required
            class="h-12"
          />
          <x-base.form.input-text
            type="password"
            name="password"
            placeholder="{{ __('password') }}"
            required
            class="h-12"
          />
          <button class="mt-3 rounded bg-indigo-800 p-3 px-6 text-white">{{ __('log in') }}</button>
        </form>
      </x-base.card>
    </div>
  </x-base.layout.container>
@endsection
