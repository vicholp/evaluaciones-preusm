@extends('stats.template.main')

@section('content')
<div class="container mx-auto grid grid-cols-12 p-3 gap-3 text-black text-opacity-90">
  <div class="col-span-12 flex flex-row items-center gap-3">
    <div class="font-medium text-lg p-2 rounded inline-block text-opacity-80 text-black">
      {{ __('Questionnaires') }} {{ $questionnaires[0]->questionnaireGroup->name }}
    </div>
    <div class="ml-auto"></div>

  </div>
  <div class="flex flex-col">
    @foreach ($questionnaires as $questionnaire)
      <a href="{{ route('stats.questionnaire', $questionnaire) }}" class="bg-white shadow rounded p-3 flex items-center justify-center col-span-3">
        {{ $questionnaire->name }}
      </a>
    @endforeach
  </div>
</div>
@endsection
