@extends('student.template.main')

@section('title', 'Resultados PREUSM')

@section('content')
  <x-base.layout.container>
    <x-base.layout.title-bar
      title="{{ $student->user->name }}"
    />
    <div class="col-span-12">
      <x-base.card header="Jornadas de ensayos">
        <x-base.list>
          @foreach($questionnaireGroups as $questionnaireGroup)
            <a href="{{ route('student.results.questionnaire-group', $questionnaireGroup) }}">
              <x-base.list.item>
                <h2>{{ $questionnaireGroup->questionnaireClass->name . " " . $questionnaireGroup->name . " " . $questionnaireGroup->period->name }}</h2>
              </x-base.list.item>
            </a>
          @endforeach
        </x-base.list>
      </x-base.card>
    </div>
  </x-base.layout.container>
@endsection
