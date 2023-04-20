@extends('student.template.main')

@section('title', 'Resultados PREUSM')

@section('content')
  <x-student.container>
    <x-teacher.layout.title-bar
      name="Resultados {{ $questionnaire->name }}"
      :previus-route="route('student.results.questionnaire-group', $questionnaire->questionnaireGroup)"
    />
    <div class="col-span-12">
      <x-student.card.card>
        <x-student.card.list>
          <x-student.card.list-key-value :key="__('subject')" :value="$questionnaire->subject->name"/>
          <x-student.card.list-key-value :key="__('score')" :value="$student->stats()->getGradeInQuestionnaire($questionnaire)"/>
        </x-student.card.list>
      </x-student.card.card>
    </div>
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
                  {{ $student->stats()->getAlternativeAttachedToQuestion($question)?->name }}
                  <span class="iconify" data-icon="mdi:close-thick"></span>
                  {{ $question->alternatives->where('correct', true)->first()?->name ?? 'n/a' }}
                </div>
              @endif
            </div>
          </x-student.card.table-row>
        @endforeach
      </x-student.card.table>
    </div>
  </x-student.container>
@endsection
