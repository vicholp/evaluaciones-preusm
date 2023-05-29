@extends('teacher.template.main')

@section('content')
  <x-base.layout.container>
    <div class="col-span-12">
      <x-base.card>
        @if ($questionnaireGroup)
          <a class="w-full py-3" href="{{ route('teacher.results.questionnaire-groups.show', $questionnaireGroup) }}">
            <div>
              {{ $questionnaireGroup->questionnaireClass->name . " " . $questionnaireGroup->name . " " . $questionnaireGroup->period->name }}
            </div>
          </a>
          <x-slot:footer :empty="true">
            <a
              href="{{ route('teacher.results.questionnaire-groups.index') }}"
              class="text-black text-opacity-60 dark:text-white dark:text-opacity-60 py-1"
            >
              {{ __('see all questionnaires') }}
            </a>
          </x-slot:footer>
        @else
          No hay cuestionarios
        @endif
      </x-base.card>
    </div>
    <div class="col-span-12">
      <a href="{{ route('teacher.results.students.index') }}">
        <x-base.card>
          {{ str(__('student results'))->ucfirst() }}
        </x-base.card>
      </a>
    </div>
    <div class="col-span-12">
      <a href="{{ route('teacher.question-bank.index') }}">
        <x-base.card>
          {{ str(__('question bank'))->ucfirst() }}
        </x-base.card>
      </a>
    </div>
  </x-base.layout.container>
@endsection
