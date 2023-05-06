@extends('main.template.main')

@section('content')

  <x-base.layout.container>
    <div class="col-span-12 flex flex-col items-center">
      <div class="flex w-full flex-col gap-5 sm:w-[50%]">
        @if ($errors->any())
          <div class="shadow-red flex rounded bg-red-500 p-4 text-white">
            <ul>
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif
        <x-base.card>
          <x-base.form action="{{ route('student.login') }}" method="POST" class="flex flex-col justify-center">
            @csrf
            <span class="text-center font-medium">
              Estudiantes
            </span>
            <div class="mt-5 flex flex-row items-center justify-around gap-1">
              <label class="px-2 text-sm">Ingresa tu Rut</label>
              <x-base.form.input-text name="rut" required class="max-w-[15ch]" />
              <button type="submit" class="h-10 rounded bg-indigo-600 px-5 text-white">Acceder</button>
            </div>
          </x-base.form>
        </x-base.card>
        <a href="{{ route('teacher.index') }}">
          <x-base.card class="items-center">
            <span class="text-center font-medium">
              Acceso colaboradores
            </span>
          </x-base.card>
        </a>
      </div>
    </div>
    </div>

  </x-base.layout.container>

@endsection
