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
          <x-teacher.card.row :key="__('name')" :value="$questionnaire->name"></x-teacher.card.element>
          <x-teacher.card.separator/>
          <x-teacher.card.row :key="__('answers')" :value="$questionnaire->stats()->getSentCount()"></x-teacher.card.element>
          <x-teacher.card.row :key="__('average score')" :value="$questionnaire->stats()->getAverageScore()"></x-teacher.card.element>
        </x-teacher.card.list>
      </x-teacher.card.card>
    </div>
    <div class="col-span-12">
      <x-teacher.card.table>
        <x-slot:header>
          <div class="col-span-3">
            {{ __('question') }}
          </div>
          <div class="col-span-3">
            {{ __('topic') }}
          </div>
          <div class="col-span-3">
            {{ __('subtopic') }}
          </div>
          <div class="col-span-3">
            {{ __('correct answers') }}
          </div>
        </x-slot:header>
        @foreach($questionnaire->questions as $question)
          <a href="{{ route('teacher.questions.show', $question)}} ">
            <x-teacher.card.table-row>
              <div class="col-span-3">
                {{ $question->position }}
              </div>
              <div class="col-span-3">
                {{ $question->topics->first()?->name }}
              </div>
              <div class="col-span-3">
                {{ $question->subtopics?->first()?->name }}
              </div>
              <div class="col-span-3">
                {{ $question->stats()->getAverageScore() }}
              </div>
              <div class="col-span-3">
                {{-- {{ $questionnaire->stats()->getStudentsSentCount() }} --}}
              </div>
            </x-teacher.card.table-row>
          </a>
        @endforeach
      </x-teacher.card.table>
    </div>
  </x-teacher.container>
@endsection
