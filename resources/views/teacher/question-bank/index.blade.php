@extends('teacher.template.main')

@section('content')

<x-teacher.container>
  <x-teacher.layout.title-bar :name="__('question bank')" />
  <div class="col-span-12">
    <x-teacher.card.card  :header="__('questions')">
      <x-teacher.card.list>
        @foreach ($questionSubjects as $subject)
          <a href="{{ route('teacher.question-bank.question-prototypes.index', ['where_subject_id' => $subject]) }}">
            <x-teacher.card.list-element>
              <div class="flex gap-3 w-full">
                <div>
                  {{ $subject->name }}
                </div>
                <div class="ml-auto"></div>
                <div>
                  {{ $subject->questionPrototypes->count() . ' ' . __('questions')}}
                </div>
              </div>
            </x-teacher.card.list-element>
          </a>
        @endforeach
      </x-teacher.card.list>
    </x-teacher.card.card>
  </div>
  <div class="col-span-12">
    <x-teacher.card.card :header="__('questionnaires')">
      <x-teacher.card.list>
        @foreach ($questionnaireSubjects as $subject)
          <a href="{{ route('teacher.question-bank.questionnaire-prototypes.index', ['where_subject_id' => $subject]) }}">
            <x-teacher.card.list-element>
              <div class="flex gap-3 w-full">
                <div>
                  {{ $subject->name }}
                </div>
                <div class="ml-auto"></div>
                <div>
                  {{ $subject->questionnairePrototypes->count() . ' ' . __('questionnaires')}}
                </div>
              </div>
            </x-teacher.card.list-element>
          </a>
        @endforeach
      </x-teacher.card.list>
    </x-teacher.card.card>
  </div>
</x-teacher.container>

@endsection
