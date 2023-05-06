@extends('teacher.template.main')

@section('title', 'Resultados PREUSM')

@section('content')
  <x-teacher.container>
    <x-teacher.layout.title-bar
      name="Resultados {{ $questionnaire->name }}"
      :previus-route="route('teacher.results.questionnaires.show', $questionnaire)"
    />
    <div class="col-span-12">
      <x-teacher.card.card>
        <x-teacher.card.list :divide="false">
          <x-teacher.card.list-key-value :key="__('name')" :value="$questionnaire->name" />
          <x-teacher.card.separator/>
          <x-teacher.card.list-key-value :key="__('answers')" :value="$questionnaire->stats()->getSentCount()" />
          <x-teacher.card.list-key-value :key="__('average score')" :value="$questionnaire->stats()->getAverageScore()" />
          <x-teacher.card.list-key-value :key="__('maximum score')" :value="$questionnaire->stats()->getMaxScore()" />
          <x-teacher.card.list-key-value :key="__('minimum score')" :value="$questionnaire->stats()->getMinScore()" />
          <x-teacher.card.list-key-value :key="__('median score')" :value="$questionnaire->stats()->getMedianScore()" />
        </x-teacher.card.list>
      </x-teacher.card.card>
    </div>
    <div class="col-span-12">
      <x-teacher.card.table>
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
          <x-teacher.card.table-row>
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
                  {{ $student->stats()->getAlternativeAttachedToQuestion($question)->name ?? 'n/a' }}
                </div>
              @endif
            </div>
          </x-teacher.card.table-row>
        @endforeach
      </x-teacher.card.table>
    </div>
  </x-teacher.container>
@endsection
