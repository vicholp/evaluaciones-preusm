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
          <x-base.list.key-value :key="__('score')" :value="$student->stats()->getScoreInQuestionnaire($questionnaire)"/>
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
      <x-student.card.table>
        <x-slot:header>
          <div class="col-span-1">
            N
          </div>
          <div class="col-span-5">
            {{ Str::ucfirst(__('topic')) }}
          </div>
          <div class="col-span-5">
            {{ Str::ucfirst(__('skill')) }}
          </div>
          <div class="col-span-1">
            Correcta
          </div>
        </x-slot:table>
        @foreach($questionnaire->questions as $question)
          <x-student.card.table-row>
            <div class="col-span-1">
              {{ $question->position }}
            </div>
            <div class="col-span-5">
              {{ $question->topics->first()?->name ?? 'n/a' }}
            </div>
            <div class="col-span-5">
              {{ $question->skills->first()?->name ?? 'n/a' }}
            </div>
            <div class="col-span-1 flex justify-center items-center">
              @if ($student->stats()->getScoreInQuestion($question))
                <span class="iconify" data-icon="mdi:check-thick"></span>
              @else
                <div class="flex gap-1 items-center">
                  <span class="iconify" data-icon="mdi:close-thick"></span>
                  {{ $question->alternatives->where('correct', true)->first()?->name ?? 'n/a' }}
                </div>
              @endif
            </div>
          </x-student.card.table-row>
        @endforeach
      </x-student.card.table>
    </div>
  </x-base.layout.container>
@endsection
