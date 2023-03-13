@extends('main.template.main')

@section('title', 'Evaluaciones - Preusm')

@section('content')

<div class="container mx-auto grid grid-cols-12 p-3 gap-3 text-black text-opacity-90 ">
  <div class="col-span-12 flex flex-col gap-3 items-center">
    <div class="w-full sm:w-[50%] flex flex-col gap-3">
      <a href="">
        <div class="bg-white rounded shadow text-opacity-80 text-black
        dark:text-opacity-80 dark:bg-gray-800 dark:text-white dark:shadow-none
        p-6"
        >
          Estudiantes
        </div>
      </a>
      <a href="{{ route('teacher.index') }}">
        <div class="bg-white rounded shadow text-opacity-80 text-black
        dark:text-opacity-80 dark:bg-gray-800 dark:text-white dark:shadow-none
        p-6"
        >
          Colaboradores
        </div>
      </a>
    </div>
  </div>
</div>

</div>

@endsection
