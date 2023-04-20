@extends('teacher.template.main')

@section('content')
  <x-teacher.container>
    <x-teacher.layout.title-bar
      :name="$question->position"
      :previus-route="route('teacher.results.questionnaires.show', $question->questionnaire)"
    ></x-teacher.layout.title-bar>
    <div class="col-span-12">
      <x-teacher.card.card>
        <x-teacher.card.list :divide="false">
          <x-teacher.card.list-key-value :key="Str::ucfirst(__('position'))" :value="$question->position" />
          <x-teacher.card.separator />
          <x-teacher.card.list-key-value :key="Str::ucfirst(__('skill'))" :value="$question->skills->first()?->name ?? 'n/a'" />
          <x-teacher.card.list-key-value :key="Str::ucfirst(__('topic'))" :value="$question->topics->first()?->name  ?? 'n/a'" />
          <x-teacher.card.list-key-value :key="Str::ucfirst(__('subtopic'))" :value="$question->subtopics->first()?->name ?? 'n/a'" />
          <x-teacher.card.list-key-value :key="Str::ucfirst(__('item type'))" :value="$question->itemTypes->first()?->name  ?? 'n/a'" />
          <x-teacher.card.separator />
          <x-teacher.card.list-key-value :key="Str::ucfirst(__('answers'))" :value="$question->students->count()" />
          <x-teacher.card.list-key-value :key="Str::ucfirst(__('logro'))" :value="$question->stats()->getAverageScore() * 100 . ' %'" />
        </x-teacher.card.list>
      </x-teacher.card.card>
    </div>
    <div class="col-span-12">
      <x-teacher.card.table>
        <x-slot:header>
          <div class="col-span-10">
            {{ Str::ucfirst(__('alternative')) }}
          </div>
          <div class="col-span-1">
          </div>
          <div class="col-span-1">
            {{ Str::ucfirst(__('answers')) }}
          </div>
        </x-slot:table>
        @foreach($question->alternatives as $alternative)
          <x-teacher.card.table-row>
            <div class="col-span-10 flex items-center gap-3">
              {{ $alternative->name }}
            </div>
            <div class="col-span-1 text-center">
              @if ($alternative->correct)
                <div class="text-green-500 text-opacity-100 font-medium">
                  correcta
                </div>
              @endif
            </div>
            <div class="col-span-1 text-center">
              {{ $alternative->students->count() }}
            </div>
          </x-teacher.card.table-row>
        @endforeach
      </x-teacher.card.table>
    </div>
    <div class="col-span-12">
      <x-teacher.card.table>
        <x-slot:header>
          <div class="col-span-8">
            {{ Str::ucfirst(__('alternative')) }}
          </div>
          <div class="col-span-1">
            {{ Str::ucfirst(__('score')) }}
          </div>
          <div class="col-span-1">

          </div>
          <div class="col-span-1">
            {{ Str::ucfirst(__('answer')) }}
          </div>
          <div class="col-span-1">

          </div>
        </x-slot:table>
        @foreach($question->students as $student)
          <x-teacher.card.table-row>
            <div class="col-span-8 flex items-center gap-3">
              {{ $student->name }}
            </div>
            <div class="col-span-1 text-center">
              {{ $student->stats()->getScoreInQuestionnaire($question->questionnaire) }}
            </div>
            <div class="col-span-1">

            </div>
            <div class="col-span-1 text-center">
              {{ $student->stats()->getAlternativeAttachedToQuestion($question)?->name }}
            </div>
            <div class="col-span-1 text-center">
              @if ($student->stats()->getScoreInQuestion($question))
                <div class="text-green-500 text-opacity-100 font-medium">
                  correcta
                </div>
              @endif
            </div>
          </x-teacher.card.table-row>
        @endforeach
      </x-teacher.card.table>
    </div>
  </x-teacher.container>
@endsection
