@extends('teacher.template.main')

@section('title', 'Resultados PREUSM')

@section('content')
  <x-base.layout.container>
    <x-base.layout.title-bar
      title="Resultados {{ $questionnaire->name }} - {{ $student->name }}"
      :previus-route="route('teacher.results.questionnaires.show', $questionnaire)"
    />
    <div class="col-span-12">
      <x-base.card>
        <x-base.list :divide="false">
          <x-base.list.key-value :key="__('questionnaire')" :value="$questionnaire->name"
              :link="route('teacher.results.questionnaires.show', $questionnaire)"/>
          <x-base.list.key-value :key="__('subject')" :value="$questionnaire->subject->name" />
          <x-base.list.separator/>
          <x-base.list.key-value :key="__('answers')" :value="$questionnaire->stats()->getSentCount()" />
          <x-base.list.key-value :key="__('average score')" :value="$questionnaire->stats()->getAverageScore()" />
          <x-base.list.key-value :key="__('maximum score')" :value="$questionnaire->stats()->getMaxScore()" />
          <x-base.list.key-value :key="__('minimum score')" :value="$questionnaire->stats()->getMinScore()" />
          <x-base.list.key-value :key="__('median score')" :value="$questionnaire->stats()->getMedianScore()" />
          <x-base.list.key-value :key="__('percentile') . ' 10'" :value="$questionnaire->stats()->getPercentileScore(10)" />
          <x-base.list.key-value :key="__('percentile') . ' 80'" :value="$questionnaire->stats()->getPercentileScore(80)" />
          <x-base.list.separator/>
          <x-base.list.key-value :key="__('student')" :value="$student->name"
            :link="route('teacher.results.students.show', $student)" />
          <x-base.list.key-value :key="__('score')" :value="$student->stats()->getScoreInQuestionnaire($questionnaire)" />
          <x-base.list.key-value :key="__('grade')" :value="$student->stats()->getGradeInQuestionnaire($questionnaire)" />
          <x-base.list.key-value :key="__('decile')" :value="$student->stats()->getDecileInQuestionnaire($questionnaire)" />
        </x-base.list>
      </x-base.card>
    </div>
    <div class="col-span-12">
      <x-teacher.card.table>
        <x-slot:header>
          <div class="col-span-1"></div>
          <div class="col-span-4">
            {{ Str::ucfirst(__('topic')) }}
          </div>
          <div class="col-span-4">
            {{ Str::ucfirst(__('skill')) }}
          </div>
          <div class="col-span-1 flex justify-center items-center">
            Correcta
          </div>
          <div class="col-span-1 flex justify-center items-center">
            Marcada
          </div>
          <div class="col-span-1 flex justify-center items-center">
          </div>
        </x-slot:table>
        @foreach($questionnaire->questions as $question)
          <x-teacher.card.table-row>
            <div class="col-span-1">
              {{ $question->position }}
            </div>
            <div class="col-span-4">
              {{ $question->topics->first()?->name ?? 'n/a' }}
            </div>
            <div class="col-span-4">
              {{ $question->skills->first()?->name ?? 'n/a' }}
            </div>
            <div class="col-span-1 flex justify-center items-center">
              {{ $question->alternatives()->whereCorrect(true)->first()->name ?? 'n/a' }}
            </div>
            <div class="col-span-1 flex justify-center items-center">
              {{ $student->stats()->getAlternativeAttachedToQuestion($question)->name ?? 'n/a' }}
            </div>
            <div class="col-span-1 flex justify-center items-center">
              @if ($student->stats()->getScoreInQuestion($question))
                <span class="iconify" data-icon="mdi:check-thick"></span>
              @endif
            </div>
          </x-teacher.card.table-row>
        @endforeach
      </x-teacher.card.table>
    </div>
  </x-base.layout.container>
@endsection
