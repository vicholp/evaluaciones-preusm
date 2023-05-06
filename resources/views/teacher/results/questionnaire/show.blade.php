@extends('teacher.template.main')

@section('content')
  <x-teacher.container>
    <x-teacher.layout.title-bar
      :name="$questionnaire->name"
      :previus-route="route('teacher.results.questionnaire-groups.show', $questionnaire->questionnaireGroup)"
    >
      <x-slot:actions>
        <a href="{{ route('teacher.results.questionnaires.students.index', $questionnaire) }}" class="bg-indigo-800 rounded p-3 text-white inline-block">
          {{ __('by students') }}
        </a>
      </x-slot:actions>
    </x-teacher.layout.title-bar>
    <div class="col-span-12">
      <x-base.card>
        <x-base.list :divide="false">
          <x-base.list.key-value :key="__('name')" :value="$questionnaire->name" />
          <x-base.list.separator/>
          <x-base.list.key-value :key="__('answers')" :value="$questionnaire->stats()->getSentCount()" />
          <x-base.list.key-value :key="__('average grade')" :value="$questionnaire->stats()->getAverageGrade()" />
          <x-base.list.key-value :key="__('average score')" :value="$questionnaire->stats()->getAverageScore()" />
          <x-base.list.key-value :key="__('maximum score')" :value="$questionnaire->stats()->getMaxScore()" />
          <x-base.list.key-value :key="__('minimum score')" :value="$questionnaire->stats()->getMinScore()" />
          <x-base.list.key-value :key="__('median score')" :value="$questionnaire->stats()->getMedianScore()" />
          <x-base.list.key-value :key="__('percentile') . ' 10'" :value="$questionnaire->stats()->getPercentileScore(10)" />
          <x-base.list.key-value :key="__('percentile') . ' 80'" :value="$questionnaire->stats()->getPercentileScore(80)" />
        </x-base.list>
      </x-base.card>
    </div>
    @foreach($questionnaire->stats()->getAverageScoreByTag() as $tagGroupName => $tagGroupStats)
      <div class="col-span-12">
        <x-teacher.card.table>
          <x-slot:header>
            <div class="col-span-10">
              {{ Str::ucfirst(__($tagGroupName)) }}
            </div>
            <div class="col-span-1 text-center">
              Preguntas
            </div>
            <div class="col-span-1 text-center">
              Logro
            </div>
          </x-slot:table>
          @foreach($tagGroupStats as $tagName => $stats)
            <x-teacher.card.table-row>
              <div class="col-span-10">
                {{ $tagName }}
              </div>
              <div class="col-span-1 text-center">
                {{ $stats['count'] }}
              </div>
              <div class="col-span-1 text-center">
                {{ $stats['average']*100 }} %
              </div>
            </x-teacher.card.table-row>
          @endforeach
        </x-teacher.card.table>
      </div>
    @endforeach
    <div class="col-span-12">
      <x-teacher.card.table>
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
          <div class="col-span-1 text-center">
            Logro
          </div>
          <div class="col-span-1 text-center">
            Omision
          </div>
        </x-slot:table>
        @foreach($questionnaire->questions as $question)
          <a href="{{ route('teacher.results.questions.show', $question) }}">
            <x-teacher.card.table-row>
              <div class="col-span-1">
                {{ $question->position }}
              </div>
              <div class="col-span-4">
                {{ $question->topics->first()?->name ?? 'n/a' }}
              </div>
              <div class="col-span-5">
                {{ $question->skills->first()?->name ?? 'n/a' }}
              </div>
              <div class="col-span-1 text-center">
                {{ $question->stats()->getAverageScore() * 100 }} %
              </div>
              <div class="col-span-1 text-center">
                {{ $question->stats()->getNullIndex() * 100 }} %
              </div>
            </x-teacher.card.table-row>
          </a>
        @endforeach
      </x-teacher.card.table>
    </div>
  </x-teacher.container>
  @endsection
