@extends('main.template.main')

@section('title', 'Evaluaciones Preusm')

@section('content')

<div class="container mx-auto grid grid-cols-12 p-3 gap-3 text-black text-opacity-90 ">
  <div class="col-span-12 flex flex-col gap-3 items-center">
    <div class="w-full sm:w-[50%] flex flex-col gap-3">
      @if ($errors->any())
        <div class="flex  bg-red-500 rounded shadow-red p-4 text-white">
          <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif
      <div class="bg-white rounded shadow text-opacity-80 text-black
        dark:text-opacity-80 dark:bg-gray-800 dark:text-white dark:shadow-none
        p-6"
      >
        <form action="{{ route('student.login') }}" method="POST">
          @csrf
          <div class="flex flex-col justify-center">
            <h2 class="text-center font-bold">Estudiantes</h2>
            <div class="flex gap-2 items-center mt-5">
              <label class="">Ingresa tu rut</label>
              <input type="text" name="rut" class="w-full h-10 border-opacity-20 border-black rounded" required>
            </div>
            <button type="submit" class="w-full h-10 rounded bg-indigo-600 text-white mt-2">Acceder</button>
          </div>
        </div>
      </form>
      <a href="{{ route('teacher.index') }}">
        <div class="bg-white rounded shadow text-opacity-80 text-black
        dark:text-opacity-80 dark:bg-gray-800 dark:text-white dark:shadow-none
        p-6"
        >
          Acceso colaboradores
        </div>
      </a>
    </div>
  </div>
</div>

</div>

@endsection
