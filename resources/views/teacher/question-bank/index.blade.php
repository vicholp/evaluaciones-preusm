@extends('teacher.template.main')

@section('content')

<x-teacher.container>
  <x-teacher.layout.title-bar :name="__('question bank')" />
  <div class="col-span-12">
    <x-teacher.card.card>
      <x-teacher.card.list>
        @foreach ($subjects as $subject)
          <a href="{{ route('teacher.question-bank.question-prototypes.index', ['subject_id' => $subject]) }}">
            <x-teacher.card.list-element>
              {{ $subject->name }} ({{$subject->questionPrototype->count() }})
            </x-teacher.card.list-element>
          </a>
        @endforeach
      </x-teacher.card.list>
    </x-teacher.card.card>
  </div>
  <div class="col-span-12">
    <x-teacher.card.card>
      <x-teacher.card.list>
        @foreach ($subjects as $subject)
          <a href="{{ route('teacher.question-bank.questionnaire-prototypes.index', ['subject_id' => $subject]) }}">
            <x-teacher.card.list-element>
              {{ $subject->name }} ({{$subject->questionnairePrototype->count() }})
            </x-teacher.card.list-element>
          </a>
        @endforeach
      </x-teacher.card.list>
    </x-teacher.card.card>
  </div>
</x-teacher.container>

@endsection
