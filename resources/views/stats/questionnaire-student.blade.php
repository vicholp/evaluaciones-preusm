@extends('stats.template.main')

@section('content')
<div class="container mx-auto grid grid-cols-12 p-3 gap-3 text-black text-opacity-90">
  <div class="col-span-12 flex flex-row items-center gap-3">
    <div class="font-medium text-lg p-2 rounded text-opacity-80 text-black items-center flex gap-3">
      <a href="{{ route('stats.questionnaire.students.index', $questionnaire) }}">
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
      <div class="col-span-1">
        {{ __('Name') }}
      </div>
      <div class="col-span-4">
        {{ __('Subtopic') }}
      </div>
      <div class="col-span-5">
        {{ __('Skill') }}
      </div>
      <div class="col-span-1">
        {{ Str::ucfirst(__('alternative')) }}
      </div>
      <div class="col-span-1 ">
        {{ Str::ucfirst(__('right')) }}
      </div>
    </div>
    <div class="py-2">
      @foreach ($questionnaire->questions as $question)
        <div class="grid grid-cols-12 py-3 px-6 hover:bg-gray-100 transition duration-300">
          <div class="col-span-1 my-auto">
            {{ $question->position }}
          </div>
          <div class="col-span-4 text-sm ">
            {{ $question->subtopic->name }}
          </div>
          <div class="col-span-5 text-sm my-auto">
            {{ $question->skill->name }}
          </div>
          <div class="col-span-1">
            {{ $student->stats()->answerToQuestion($question)->name }}
          </div>
          <div class="col-span-1">
            {{ $student->stats()->correctAnswerToQuestion($question) ? 'si' : 'no'}}
          </div>
        </div>
      @endforeach
    </div>
  </div>
</div>
@endsection
