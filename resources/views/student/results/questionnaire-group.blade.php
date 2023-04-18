@extends('student.template.main')

@section('title', 'Resultados PREUSM')

@section('content')
  <x-student.container>
    <x-teacher.layout.title-bar
      name="Resultados {{ $questionnaireGroup->name }}"
      :previus-route="route('student.index')"
    />
    <div class="col-span-12">
      <x-student.card.table>
        <x-slot:header>
          <div class="col-span-6">
            {{ Str::ucfirst(__('subject')) }}
          </div>
          <div class="col-span-3 flex justify-center">
            Correctas
          </div>
          <div class="col-span-3 flex justify-center">
            Puntaje
          </div>
        </x-slot:table>
        @foreach($questionnaires as $questionnaire)
          <a href="{{ route('student.results.questionnaire', $questionnaire) }}">
            <x-student.card.table-row>
              <div class="col-span-6">
                {{ $questionnaire->subject->name }}
              </div>
              <div class="col-span-3 flex justify-center">
                {{ $student->stats()->getScoreInQuestionnaire($questionnaire) }}
              </div>
              <div class="col-span-3 flex justify-center">
                {{ $student->stats()->getScoreInQuestionnaire($questionnaire) }}
              </div>
            </x-student.card.table-row>
          </a>
        @endforeach
      </x-student.card.table>
    </div>
  </x-student.container>
@endsection
