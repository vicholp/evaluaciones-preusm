@extends('stats.template.main')

@section('content')
<div class="container mx-auto grid grid-cols-12 p-3 gap-3 text-black text-opacity-90">
  <div class="col-span-12 flex flex-row items-center gap-3">
    <div class="font-medium text-lg p-2 rounded inline-block text-opacity-80 text-black">
      {{ __('questionnaire groups') }}
    </div>
    <div class="ml-auto"></div>

  </div>
  <div class="flex flex-col gap-3 col-span-12">
    @foreach ($periods as $period)
    <div>
      <div class="font-medium p-2 rounded inline-block text-opacity-80 text-black">
        {{ __('period') }} {{ $period->name }}
      </div>
      <div class="flex gap-2">
        @foreach ($period->questionnaireGroups as $questionnaireGroup)
        <a href="{{ route('stats.questionnaireGroup', $questionnaireGroup) }}" class="bg-white shadow rounded p-3 flex items-center justify-center">
          {{ $questionnaireGroup->name }}
        </a>
        @endforeach
      </div>
    </div>
    @endforeach
  </div>
</div>

@endsection
