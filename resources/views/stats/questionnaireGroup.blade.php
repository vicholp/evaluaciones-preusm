@extends('stats.template.main')

@section('content')
<div class="container mx-auto grid grid-cols-12 p-3 gap-3 text-black text-opacity-90">
  <div class="col-span-12 flex flex-row items-center gap-3">
    <div class="font-medium text-lg p-2 rounded text-opacity-80 text-black items-center flex gap-3">
      <a href="{{ route('stats.index') }}">
        <span class="iconify-inline text-xl" data-icon="mdi:arrow-left"></span>
      </a>
      <h3>
        {{ __('Questionnaires') }} {{ $questionnaires[0]->questionnaireGroup->name ?? ''}}
      </h3>
    </div>
    <div class="ml-auto"></div>
  </div>
  <div class="col-span-12 flex flex-col divide-y card">
    <div class="grid grid-cols-12 px-6 py-3 text-black font-medium bg-black  bg-opacity-5 rounded items-center">
      <div class="col-span-8">
        {{ Str::ucfirst(__('subject')) }}
      </div>
      <div class="col-span-2">
        {{ Str::ucfirst(__('answers')) }}
      </div>
      <div class="col-span-2">
        {{ Str::ucfirst(__('average')) }}
      </div>
    </div>
    <div class="py-2">
      @foreach ($questionnaires as $questionnaire)
        <a class="grid grid-cols-12 py-3 px-6 hover:bg-gray-100 transition duration-300" href="{{ route('stats.questionnaire', $questionnaire) }}">
          <div class="col-span-8 my-auto">
            {{ Str::of($questionnaire->subject->name)->ucfirst() }}
          </div>
          <div class="col-span-2">
            {{ $questionnaire->stats()->studentsSent()->count() }}
          </div>
          <div class="col-span-2">
            {{ round($questionnaire->questions->count()*$questionnaire->average) }} correctas - {{ $questionnaire->getGrade(round($questionnaire->questions->count()*$questionnaire->average)) }} puntos
          </div>
        </a>
      @endforeach
    </div>
  </div>
  <h2 class="col-span-12 text-lg font-medium pt-3 pb-1">
    Estudiantes que no riendieron algun enssayo
  </h2>
  <div class="col-span-12 flex flex-col divide-y card">
    <div class="grid grid-cols-12 px-6 py-3 text-black font-medium bg-black  bg-opacity-5 rounded items-center">
      <div class="col-span-10">
        {{ Str::ucfirst(__('name')) }}
      </div>
      <div class="col-span-2">
        {{ Str::ucfirst(__('subject')) }}
      </div>
    </div>
    <div class="py-2">
      @foreach ($questionnaires as $questionnaire)
        @foreach($questionnaire->stats()->studentsDidntSend() as $student)
          <a class="grid grid-cols-12 py-3 px-6 hover:bg-gray-100 transition duration-300" href="{{ route('students.index', $student->user) }}">
            <div class="col-span-10 my-auto">
              {{$student->user->name}}
            </div>
            <div class="col-span-2">
              {{ $questionnaire->subject->name }}
            </div>
          </a>
        @endforeach
      @endforeach
    </div>
  </div>
</div>
@endsection
