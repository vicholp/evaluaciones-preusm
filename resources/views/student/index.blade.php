@extends('student.template.main')

@section('title', 'Resultados PREUSM')

@section('content')
  <x-student.container>
    <x-teacher.layout.title-bar
      name="{{ $student->user->name }}"
    />
    <div class="col-span-12">
      <x-student.card.card header="Jornadas de ensayos">
        <x-student.card.list>
          @foreach($questionnaireGroups as $questionnaireGroup)
          <a href="{{ route('student.results.questionnaire-group', $questionnaireGroup) }}">
            <x-student.card.list-item>
              <h2>{{ $questionnaireGroup->name }}</h2>
            </x-student.card.list-item>
          </a>
          @endforeach
        </x-student.card.list>
      </x-student.card.card>
    </div>
  </x-student.container>
@endsection
