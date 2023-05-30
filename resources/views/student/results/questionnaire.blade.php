@extends('student.template.main')

@section('title', 'Resultados PREUSM')

@section('content')
  <x-base.layout.container>
    <x-base.layout.title-bar
      title="Resultados {{ $questionnaire->name }}"
      :previus-route="route('student.results.questionnaire-group', $questionnaire->questionnaireGroup)"
    />
    <div class="col-span-12">
      <x-base.card>
        <x-base.list :divide="false">
          <x-base.list.key-value :key="__('subject')" :value="$questionnaire->subject->name"/>
          <x-base.list.key-value :key="__('score')" :value="$student->stats()->getScoreInQuestionnaire($questionnaire) . '/' .
            $questionnaire->grading()->gradableQuestions()"/>
          <x-base.list.key-value :key="__('grade')" :value="$student->stats()->getGradeInQuestionnaire($questionnaire)"/>
        </x-base.list>
      </x-base.card>
    </div>
    @foreach($student->stats()->getAverageScoreByTagsOnQuestionnaire($questionnaire) as $tagGroup)
      <div class="col-span-12">
        <x-student.card.table>
          <x-slot:header>
            <div class="col-span-10">
              {{ Str::ucfirst(__($tagGroup['name'])) }}
            </div>
            <div class="col-span-1 text-center">
              Preguntas
            </div>
            <div class="col-span-1 text-center">
              Logro
            </div>
          </x-slot:table>
          @foreach($tagGroup['tags'] as $tag)
            <x-student.card.table-row>
              <div class="col-span-10">
                {{ $tag['name'] }}
              </div>
              <div class="col-span-1 text-center">
                {{ $tag['count'] }}
              </div>
              <div class="col-span-1 text-center">
                {{ $tag['average'] * 100 }}%
              </div>
            </x-student.card.table-row>
          @endforeach
        </x-student.card.table>
      </div>
    @endforeach
    <div class="col-span-12">
        <x-base.card :padding="false">
        <x-base.table>
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
            <x-base.table.row>
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
                @if ($question->pilot)
                  <x-base.pill :body="__('pilot')" />
                @elseif ($student->stats()->getScoreInQuestion($question))
                  <span class="iconify" data-icon="mdi:check-thick"></span>
                @endif
              </div>
            </x-base.table.row>
          @endforeach
        </x-base.table>
      </x-base.card>
    </div>
  </x-base.layout.container>
@endsection
