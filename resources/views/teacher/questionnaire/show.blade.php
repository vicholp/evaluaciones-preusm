@extends('teacher.template.main')

@section('content')
  <x-teacher.container>
    <x-teacher.layout.title-bar
      :name="$questionnaire->name"
      :previus-route="route('teacher.questionnaire-groups.show', $questionnaire->questionnaireGroup)"
    >
      <x-slot:actions>
        <a href="{{ route('teacher.questionnaires.students.index', $questionnaire) }}" class="bg-indigo-800 rounded p-3 text-white inline-block">
          {{ __('by students') }}
        </a>
      </x-slot:actions>
    </x-teacher.layout.title-bar>
    <div class="col-span-12">
      <x-teacher.card.card>
        <x-teacher.card.list :divide="false">
          <x-teacher.card.list-key-value :key="__('name')" :value="$questionnaire->name"></x-teacher.card.list-key-value>
          <x-teacher.card.separator/>
          <x-teacher.card.list-key-value :key="__('answers')" :value="$questionnaire->stats()->getSentCount()"></x-teacher.card.list-key-value>
          <x-teacher.card.list-key-value :key="__('average score')" :value="$questionnaire->stats()->getAverageScore()"></x-teacher.card.list-key-value>
        </x-teacher.card.list>
      </x-teacher.card.card>
    </div>
    <div class="col-span-12">
      <x-student.card.table>
        <x-slot:header>
          <div class="col-span-1">
            N
          </div>
          <div class="col-span-4">
            {{ Str::ucfirst(__('topic')) }}
          </div>
          <div class="col-span-5">
            {{ Str::ucfirst(__('skill')) }}
          </div>
          <div class="col-span-1">
            Logro
          </div>
          <div class="col-span-1">
            Omision
          </div>
        </x-slot:table>
        @foreach($questionnaire->questions as $question)
          <x-student.card.table-row>
            <div class="col-span-1">
              {{ $question->position }}
            </div>
            <div class="col-span-4">
              {{ $question->topics->first()?->name ?? 'n/a' }}
            </div>
            <div class="col-span-5">
              {{ $question->skills->first()?->name ?? 'n/a' }}
            </div>
            <div class="col-span-1">
              {{ $question->stats()->getAverageScore()*100 }} %
            </div>
            <div class="col-span-1">
              {{ $question->stats()->getNullIndex()*100 }} %

            </div>
          </x-student.card.table-row>
        @endforeach
      </x-student.card.table>
    </div>
  </x-teacher.container>
@endsection
