@extends('student.template.main')

@section('title', 'Resultados PREUSM')

@section('content')
<div class="container mx-auto grid grid-cols-12 p-3 gap-3">
  <div class="col-span-12 md:col-span-4 md:col-start-5">
    @if ($errors->any())
      <div class="flex col-span-12 bg-red-500 rounded shadow-red p-4 text-white">
        <ul>
          @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif
    <div class="bg-white rounded shadow">
      <div class="flex flex-row items-center gap-3 justify-center">
        <div class="font-medium text-lg p-2 rounded text-opacity-80 text-black text-center">
          Hola!
        </div>
      </div>
      <div class="col-span-12">
        <form action="{{ route('students.get') }}" method="GET" class="w-full flex flex-col items-center gap-4">
          <div class="flex justify-center items-center gap-4">
            <h3>Ingresa tu rut:</h3>
            <input type="text" name="rut" class="rounded" placeholder="12345678-9" required>
          </div>
          <p class="text-sm text-gray-500">Tu rut debe estar sin puntos y con guion</p>
          <button type="submit" class="p-3 bg-indigo-800 text-white rounded w-full">Resultados</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
