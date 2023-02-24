@extends('teacher.template.main')

@section('content')
  <x-teacher.container>
    <div class="col-span-12 ">
      <x-teacher.card.card>
        <a href="{{ route('teacher.questionnaire-groups.show', $questionnaireGroup) }}">
          {{ $questionnaireGroup->name }}
        </a>
        <x-slot:footer>
          <a href="{{ route('teacher.questionnaire-groups.index') }}">
            {{ __('see all questionnaires') }}
          </a>
        </x-slot:footer>
      </x-teacher.card.card>
    </div>
    <div class="col-span-12">
      <a href="{{ route('teacher.question-bank.index') }}">
        <x-teacher.card.card>
          {{ __('question bank') }}
        </x-teacher.card.card>
      </a>
    </div>
  </x-teacher.container>
@endsection
