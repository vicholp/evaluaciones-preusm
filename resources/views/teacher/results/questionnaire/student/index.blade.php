@extends('teacher.template.main')

@section('content')
  <x-teacher.container>
    <x-teacher.layout.title-bar
      :name="$questionnaire->name"
      :previus-route="route('teacher.results.questionnaire-groups.show', $questionnaire->questionnaireGroup)"
    >
      <x-slot:actions>
        <a href="{{ route('teacher.results.questionnaires.show', $questionnaire) }}" class="bg-indigo-800 rounded p-3 text-white inline-block">
          {{ __('by questions') }}
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
      <x-teacher.card.table>
        <x-slot:header>
          <div class="col-span-11">
            Nombre
          </div>
          <div class="col-span-1 text-center">
            Correctas
          </div>
        </x-slot:table>
        @foreach($students as $student)
          <a href="{{ route('teacher.results.questionnaires.students.show', [$questionnaire, $student])}}">
            <x-teacher.card.table-row>
              <div class="col-span-11">
                {{ $student->name }}
              </div>
              <div class="col-span-1 text-center">
                {{ $student->stats()->getScoreInQuestionnaire($questionnaire) }}
              </div>
            </x-teacher.card.table-row>
          </a>
        @endforeach
      </x-teacher.card.table>
    </div>
  </x-teacher.container>
@endsection
