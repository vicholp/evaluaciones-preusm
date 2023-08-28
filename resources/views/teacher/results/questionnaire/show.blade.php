@extends('teacher.template.main')

@section('content')
  <x-teacher.container>
    <x-teacher.layout.title-bar
      :name="$questionnaire->name"
      :previus-route="route('teacher.results.questionnaire-groups.show', $questionnaire->questionnaireGroup)"
    >
      <x-slot:actions>
        @if (!$questionnaire->stats()->isUpdated())
          <x-base.action
            :href="route('teacher.results.questionnaires.update-stats', $questionnaire)"
            :body="__('update stats')"
          />
        @endif
        <a
          href="{{ route('teacher.results.questionnaires.students.index', $questionnaire) }}"
          class="inline-block rounded bg-indigo-800 p-3 text-white"
        >
          {{ __('by students') }}
        </a>
      </x-slot:actions>
    </x-teacher.layout.title-bar>
    <div class="col-span-12">
      <x-base.card>
        <x-base.list :divide="false">
          <x-base.list.key-value
            :key="__('name')"
            :value="$questionnaire->name"
          />
          <x-teacher.card.list-key-value
            :key="__('subject')"
            :value="$questionnaire->subject->name"
          />
          @if ($questionnaire->prototype)
            <x-base.list.key-value
              :key="__('prototype')"
              :value="$questionnaire->prototype->name"
              :link="route(
                  'teacher.question-bank.questionnaire-prototypes.show',
                  $questionnaire->prototype->parent,
              )"
            />
          @else
            <x-base.list.key-value
              :key="__('prototype')"
              value="sin prototipo"
            />
          @endif
          <x-base.list.separator />
          <x-base.list.key-value
            :key="__('answers')"
            :value="$questionnaire->stats()->getSentCount()"
          />
          <x-base.list.key-value
            :key="__('average grade')"
            :value="$questionnaire->stats()->getAverageGrade()"
          />
          <x-base.list.key-value
            :key="__('average score')"
            :value="$questionnaire->stats()->getAverageScore()"
          />
          <x-base.list.key-value
            :key="__('discrimination index')"
            :value="$questionnaire->stats()->getDiscriminationIndex()"
          />
          <x-base.list.key-value
            :key="__('gradable questions')"
            :value="$questionnaire->grading()->gradableQuestions()"
          />
          <x-base.list.key-value
            :key="__('maximum score')"
            :value="$questionnaire->stats()->getMaxScore()"
          />
          <x-base.list.key-value
            :key="__('minimum score')"
            :value="$questionnaire->stats()->getMinScore()"
          />
          <x-base.list.key-value
            :key="__('median score')"
            :value="$questionnaire->stats()->getMedianScore()"
          />
          <x-base.list.key-value
            :key="__('percentile') . ' 10'"
            :value="$questionnaire->stats()->getPercentileScore(10)"
          />
          <x-base.list.key-value
            :key="__('percentile') . ' 80'"
            :value="$questionnaire->stats()->getPercentileScore(80)"
          />
        </x-base.list>
      </x-base.card>
    </div>
    @foreach ($questionnaire->stats()->getAverageScoreByTag() as $tagGroupName => $tagGroupStats)
      <div class="col-span-12">
        <x-base.card :padding="false">
          <x-base.table>
            <x-slot:header>
              <div class="col-span-10">
                {{ Str::ucfirst(__($tagGroupName)) }}
              </div>
              <div class="col-span-1 text-right">
                Preguntas
              </div>
              <div class="col-span-1 text-right">
                Logro
              </div>
              </x-slot:table>
              @foreach ($tagGroupStats as $tagName => $stats)
                <x-base.table.row>
                  <div class="col-span-10">
                    {{ $tagName }}
                  </div>
                  <div class="col-span-1 text-right">
                    {{ $stats['count'] }}
                  </div>
                  <div class="col-span-1 text-right">
                    {{ $stats['average'] * 100 }} %
                  </div>
                </x-base.table.row>
              @endforeach
          </x-base.table>
        </x-base.card>
      </div>
    @endforeach
    <div class="col-span-12">
      <x-base.card header="Grafico de distribucion de puntajes">
        <teacher-results-charts-questionnaire-score :scores='@json($questionnaire->stats()->getStudentCountByScore())' />
      </x-base.card>
    </div>
    <div class="col-span-12">
      <x-base.card :padding="false">
        <x-base.table>
          <x-slot:header>
            <div class="col-span-1"></div>
            <div class="col-span-4 flex items-center">
              {{ Str::ucfirst(__('topic')) }}
            </div>
            <div class="col-span-3 flex items-center">
              {{ Str::ucfirst(__('skill')) }}
            </div>
            <div class="col-span-1 flex items-center justify-end">
              Logro
            </div>
            <div class="col-span-1 flex items-center text-right">
              Indice de discriminacion
            </div>
            <div class="col-span-1 flex items-center justify-end">
              Omision
            </div>
            <div class="col-span-1 flex items-center justify-end">
              Piloto
            </div>
            </x-slot:table>
            @foreach ($questionnaire->questions as $question)
              <a href="{{ route('teacher.results.questions.show', $question) }}">
                <x-base.table.row>
                  <div class="col-span-1">
                    {{ $question->position }}
                  </div>
                  <div class="col-span-4">
                    {{ $question->topics->first()?->name ?? 'n/a' }}
                  </div>
                  <div class="col-span-3">
                    {{ $question->skills->first()?->name ?? 'n/a' }}
                  </div>
                  <div class="col-span-1 text-right">
                    {{ $question->stats()->getAverageScore() * 100 }} %
                  </div>
                  <div class="col-span-1 text-right">
                    {{ $question->stats()->getDiscriminationIndex() }}
                  </div>
                  <div class="col-span-1 text-right">
                    {{ $question->stats()->getNullIndex() * 100 }} %
                  </div>
                  <div class="col-span-1 flex items-center justify-end">
                    @if ($question->pilot)
                      <x-base.pill :body="__('pilot')" />
                    @endif
                  </div>
                </x-base.table.row>
              </a>
            @endforeach
        </x-base.table>
      </x-base.card>
    </div>
  </x-teacher.container>
@endsection
