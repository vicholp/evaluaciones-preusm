@extends('stats.template.main')

@section('content')
<div class="container mx-auto grid grid-cols-12 p-3 gap-3 text-black text-opacity-90">
  <div class="col-span-12 flex flex-row items-center gap-3">
    <div class="font-medium text-lg p-2 rounded text-opacity-80 text-black items-center flex gap-3">
      <a href="{{ route('stats.questionnaire', $questionnaire) }}">
        <span class="iconify-inline text-xl" data-icon="mdi:arrow-left"></span>
      </a>
      <h3 class="">
        {{ $questionnaire->name }}
      </h3>
    </div>
    <div class="ml-auto"></div>
  </div>
  <div class="col-span-12 flex flex-col divide-y card">
    <div class="grid grid-cols-12 px-6 py-3 text-black font-medium bg-black  bg-opacity-5 rounded items-center">
      <div class="col-span-5">
        {{ Str::ucfirst(__('name')) }}
      </div>
      <div class="col-span-4">
        {{ Str::ucfirst(__('division')) }}
      </div>
      <div class="col-span-3">
        {{ Str::ucfirst(__('score')) }}
      </div>
    </div>
    <div class="py-2">
      @foreach ($students as $student)
        @if($student->stats()->sentQuestionnaire($questionnaire))
          <a class="grid grid-cols-12 py-3 px-6 hover:bg-gray-100 transition duration-300" href="{{ route('stats.questionnaire.students.show', [$questionnaire,  $student]) }}">
        @else
          <a class="grid grid-cols-12 py-3 px-6 hover:bg-gray-100 transition duration-300">
        @endif
          <div class="col-span-5 my-auto">
            {{ $student->user->name }}
          </div>
          <div class="col-span-4">
            {{ $student->divisions()->whereSubjectId($questionnaire->subject->id)->first()->name ??
               $student->divisions()->whereName('tercero')->first()->name ??
               'No inscritos'
            }}
          </div>
          <div class="col-span-3 my-auto">
            @if ( $student->stats()->scoreInQuestionnaire($questionnaire) === -1 )
              No rendido
            @else
              {{ $student->stats()->scoreInQuestionnaire($questionnaire) }} correctas - {{ $student->stats()->gradeInQuestionnaire($questionnaire) }} puntos
            @endif
          </div>
        </a>
      @endforeach
    </div>
  </div>
</div>
@endsection
