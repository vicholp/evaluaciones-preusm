@extends('teacher.template.main')

@section('content')
  <x-teacher.container>
    <div class="col-span-12 bg-white rounded shadow flex flex-col divide-y">
      <a class="p-3" href="{{ route('teacher.questionnaire-groups.show', $questionnaireGroup) }}">
        {{ $questionnaireGroup->name }}
      </a>
      <a class="px-3 py-2 text-black text-opacity-60" href="{{ route('teacher.questionnaire-groups.index') }}">
        {{ __('See all questionnaires') }}
      </a>
    </div>
    <div class="col-span-12 bg-white rounded shadow flex flex-col divide-y">
    </div>
  </x-teacher.container>
@endsection
