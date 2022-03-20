@extends('student.template.main')

@section('content')
<div class="container mx-auto grid grid-cols-12 p-3 gap-3">
  <div class="col-span-12 flex flex-row items-center gap-3">
    <div class="font-medium text-lg p-2 rounded inline-block text-opacity-80 text-black">
      Hola {{ $student->user->name }}
    </div>
    <div class="ml-auto"></div>
  </div>
  @foreach($questionnaire_groups as $questionnaire_group)
  <div class="col-span-12 bg-white rounded shadow p-3 flex flex-col gap-3">
    <h2>{{ $questionnaire_group->name }} - {{ $questionnaire_group->period->name }}</h2>
    <div class="flex flex-col gap-4 p-3">
      @foreach($subjects as $subject)
        <div class="grid grid-cols-12">
          <div class="col-span-4 text-black text-opacity-90">
            {{ Str::of($subject->name)->ucfirst() }}
          </div>
          <div class="col-span-8 text-black">
            @if($subject->questionnaires()->whereQuestionnaireGroupId($questionnaire_group->id)->first())
              @if($student->score($subject->questionnaires()->whereQuestionnaireGroupId($questionnaire_group->id)->first()) >= 0)
                {{ $subject->questionnaires()->whereQuestionnaireGroupId($questionnaire_group->id)->first()->getGrade($student->score($subject->questionnaires()->whereQuestionnaireGroupId($questionnaire_group->id)->first())) }} puntos
              @else
                No rendido
              @endif
            @else
              Aun no subido
            @endif
          </div>
        </div>
      @endforeach
    </div>
  </div>
  @endforeach
</div>
@endsection
