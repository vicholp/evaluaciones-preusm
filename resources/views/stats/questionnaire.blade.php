@extends('stats.template.main')

@section('content')
<div class="container mx-auto grid grid-cols-12 p-3 gap-3 text-black text-opacity-90">
  <div class="col-span-12 flex flex-row items-center gap-3">
    <div class="font-medium text-lg p-2 rounded text-opacity-80 text-black items-center flex gap-3">
      <a href="{{ route('stats.questionnaireGroup', $questionnaire->questionnaireGroup) }}">
        <span class="iconify-inline text-xl" data-icon="mdi:arrow-left"></span>
      </a>
      <h3 class="">
        {{ $questionnaire->name }}
      </h3>
    </div>
    <div class="ml-auto"></div>
  </div>
  <div class="col-span-12 bg-white rounded shadow p-3 flex flex-col gap-3">
    <div class="flex flex-col gap-4 p-3">
      <div class="grid grid-cols-12">
        <div class="col-span-4 text-black text-opacity-90"> Id </div>
        <div class="col-span-8 text-black"> {{ $questionnaire->id }} </div>
      </div>
      <div class="grid grid-cols-12">
        <div class="col-span-4 text-black text-opacity-90"> {{ __('Name') }} </div>
        <div class="col-span-8 text-black"> {{ $questionnaire->name }} </div>
      </div>
      <div class="grid grid-cols-12">
        <div class="col-span-4 text-black text-opacity-90"> {{ __('Subject') }} </div>
        <div class="col-span-8 text-black"> {{ $questionnaire->subject->name }} </div>
      </div>
      <div class="grid grid-cols-12">
        <div class="col-span-4 text-black text-opacity-90"> {{ __('Questionnaire group') }} </div>
        <div class="col-span-8 text-black"> {{ $questionnaire->questionnaireGroup->name }} </div>
      </div>
    </div>
  </div>
  <div class="col-span-12 flex flex-col divide-y card">
    <div class="grid grid-cols-12 px-6 py-3 text-black font-medium bg-black  bg-opacity-5 rounded">
      <div class="col-span-1">
        {{ __('Name') }}
      </div>
      <div class="col-span-3">
        {{ __('Subtopic') }}
      </div>
      <div class="col-span-6">
        {{ __('Skill') }}
      </div>
      <div class="col-span-2">
        Red flags
      </div>
    </div>
    <div class="py-2">
      @foreach ($questionnaire->questions as $question)
        <a class="grid grid-cols-12 py-3 px-6" href="{{ route('stats.question', $question) }}">
          <div class="col-span-1">
            {{ $question->position }}
          </div>
          <div class="col-span-3 text-sm">
            {{ $question->subtopic->name }}
          </div>
          <div class="col-span-6 text-sm">
            {{ $question->tags()->whereTagGroupId(3)->first()->name }}
          </div>
          <div class="col-span-2 text-sm">
            @if ($question->full_score)
              {{ $question->full_score }} / 5
            @else
              OK
            @endif
          </div>
        </a>
      @endforeach
    </div>
  </div>
</div>
@endsection
