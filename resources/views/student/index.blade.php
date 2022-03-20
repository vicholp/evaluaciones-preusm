@extends('student.template.main')

@section('content')
<div class="container mx-auto grid grid-cols-12 p-3 gap-3">
  <div class="col-span-12 flex flex-row items-center gap-3">
    <div class="font-medium text-lg p-2 rounded inline-block text-opacity-80 text-black">
      Hola {{ $student->user->name }}
    </div>
    <div class="ml-auto"></div>
  </div>
  <div class="col-span-12 bg-white rounded shadow p-3 flex flex-col gap-3">
    <h2 class="text-lg">Resultados de la ultima jornada de evaluacion</h2>
    <div class="flex flex-col gap-4 p-3">
      @foreach($student->divisions as $division)
        <div class="grid grid-cols-12">
          <div class="col-span-4 text-black text-opacity-90"> {{ $division->subject->name }} </div>
          @if($division->subject->questionnaires->first->get())
            <div class="col-span-8 text-black">
              {{ $division->subject->questionnaires->first->get()->getGrade($student->grade($division->subject->questionnaires->first->get())) }} puntos
            </div>
          @else
            <div class="col-span-8 text-black">Aun no subido</div>
          @endif
        </div>
      @endforeach
    </div>
  </div>
</div>
@endsection
