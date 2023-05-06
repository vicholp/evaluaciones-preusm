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
          <x-teacher.card.list-key-value :key="__('name')" :value="$questionnaire->name" />
          <x-teacher.card.separator/>
          <x-teacher.card.list-key-value :key="__('answers')" :value="$questionnaire->stats()->getSentCount()" />
            <x-teacher.card.list-key-value :key="__('average grade')" :value="$questionnaire->stats()->getAverageGrade()" />
            <x-teacher.card.list-key-value :key="__('average score')" :value="$questionnaire->stats()->getAverageScore()" />
            <x-teacher.card.list-key-value :key="__('maximum score')" :value="$questionnaire->stats()->getMaxScore()" />
            <x-teacher.card.list-key-value :key="__('minimum score')" :value="$questionnaire->stats()->getMinScore()" />
            <x-teacher.card.list-key-value :key="__('median score')" :value="$questionnaire->stats()->getMedianScore()" />
            <x-teacher.card.list-key-value :key="__('percentile') . ' 10'" :value="$questionnaire->stats()->getPercentileScore(10)" />
            <x-teacher.card.list-key-value :key="__('percentile') . ' 80'" :value="$questionnaire->stats()->getPercentileScore(80)" />
        </x-teacher.card.list>
      </x-teacher.card.card>
    </div>
    <div class="col-span-12">
      <x-teacher.card.table>
        <x-slot:header>
          <div class="col-span-4">
            Nombre
          </div>
          <div class="col-span-5">

          </div>
          <div class="col-span-1 text-center">
            Decil
          </div>
          <div class="col-span-1 text-center">
            Puntaje
          </div>
          <div class="col-span-1 text-center">
            Correctas
          </div>
        </x-slot:table>
        @foreach($students as $student)
          <a href="{{ route('teacher.results.questionnaires.students.show', [$questionnaire, $student])}}">
            <x-teacher.card.table-row>
              <div class="col-span-4 flex items-center">
                {{ $student->name }}
              </div>
              <div class="col-span-5 flex flex-row gap-2 items-center justify-end">

              </div>
              <div class="col-span-1 text-center">

                @if ($student->stats()->isScoreLowInQuestionnaire($questionnaire))
                  <div class="bg-red-500 bg-opacity-90 rounded text-sm font-medium px-2">
                    {{ $student->stats()->getDecileInQuestionnaire($questionnaire) }} - Bajo
                  </div>
                @elseif ($student->stats()->isScoreHighInQuestionnaire($questionnaire))
                  <div class="bg-green-500 bg-opacity-90 rounded text-sm font-medium px-2">
                    {{ $student->stats()->getDecileInQuestionnaire($questionnaire) }} - Alto
                  </div>
                @else
                  <div class="">
                    {{ $student->stats()->getDecileInQuestionnaire($questionnaire) }}
                  </div>
                @endif
              </div>
              <div class="col-span-1 text-center">
                {{ $student->stats()->getGradeInQuestionnaire($questionnaire) }}
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
