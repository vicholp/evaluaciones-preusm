@extends('teacher.template.main')

@section('content')
  <x-base.layout.container>
    <x-base.layout.title-bar
      :title="__('students')"
      :previus-route="route('teacher.results.students.index')"
    />
    <div class="col-span-12">
      <x-base.card :padding="false">
        <x-base.table>
          <x-slot:header>
            <div class="col-span-9">
              {{ __('questionnaire') }}
            </div>
            <div class="col-span-2 text-center">
              {{ __('score') }} / total
            </div>
            <div class="col-span-1 text-center">
              {{ __('decile') }}
            </div>
          </x-slot:header>
          @foreach ($questionnaires as $questionnaire)
            <x-base.table.row :link="route('teacher.results.questionnaires.students.show', [$questionnaire, $student])">
              <div class="col-span-9">
                {{ $questionnaire->name }}
              </div>
              <div class="col-span-2 text-center">
                {{ $student->stats()->getScoreInQuestionnaire($questionnaire) }} / {{ $questionnaire->grading()->gradableQuestions() }}
              </div>
              <div class="col-span-1 text-center">
                {{ $student->stats()->getDecileInQuestionnaire($questionnaire) }}
              </div>
            </x-base.table.row>
          @endforeach
        </x-base.table>
      </x-base.card>
    </div>
  </x-base.layout.container>
@endsection
