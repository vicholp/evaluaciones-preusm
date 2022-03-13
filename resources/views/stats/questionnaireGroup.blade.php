@extends('stats.template.main')

@section('content')
<div class="container mx-auto grid grid-cols-12 p-3 gap-3 text-black text-opacity-90">
  <div class="col-span-12 flex flex-row items-center gap-3">
    <div class="font-medium text-lg p-2 rounded text-opacity-80 text-black items-center flex gap-3">
      <a href="{{ route('stats.index') }}">
        <span class="iconify-inline text-xl" data-icon="mdi:arrow-left"></span>
      </a>
      <h3>
        {{ __('Questionnaires') }} {{ $questionnaires[0]->questionnaireGroup->name }}
      </h3>
    </div>
    <div class="ml-auto"></div>

  </div>
  <div class="flex flex-row gap-3 col-span-12">
    @foreach ($questionnaires as $questionnaire)
      <a href="{{ route('stats.questionnaire', $questionnaire) }}" class="bg-white shadow rounded p-3 flex items-center justify-center col-span-3">
        {{ $questionnaire->subject->name }}
      </a>
    @endforeach
  </div>

</div>
@endsection
