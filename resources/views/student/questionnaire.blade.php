@extends('student.template.main')

@section('title', 'Resultados PREUSM')

@section('content')
  <div class="container mx-auto grid grid-cols-12 p-3 gap-3">
    <div class="col-span-12 flex flex-row items-center gap-3">
      <div class="font-medium text-lg p-2 rounded inline-block text-opacity-80 text-black">
        Hola {{ $student->user->name }}
      </div>
      <div class="ml-auto"></div>
    </div>
    <div class="col-span-12 bg-white rounded shadow p-3 flex flex-col gap-3">
      <div class="flex flex-col gap-4 p-3">
        <div class="grid grid-cols-12">
          <div class="col-span-4 text-black text-opacity-90"> {{ __('Name') }} </div>
          <div class="col-span-8 text-black"> {{ $questionnaire->name }} </div>
        </div>
        <div class="grid grid-cols-12">
          <div class="col-span-4 text-black text-opacity-90"> {{ __('Subject') }} </div>
          <div class="col-span-8 text-black"> {{ $questionnaire->subject->name }} </div>
        </div>
        <div class="grid grid-cols-12">
          <div class="col-span-4 text-black text-opacity-90"> {{ __('Questionnaire group') }} </div>
          <div class="col-span-8 text-black"> {{ $questionnaire->questionnaireGroup->name }} </div>
        </div>
        <div class="h-[1px] w-full bg-gray-100 rounded"></div>
        <div class="grid grid-cols-12">
          <div class="col-span-4 text-black text-opacity-90"> Correctas </div>
          <div class="col-span-8 text-black"> {{ $student->stats()->scoreInQuestionnaire($questionnaire) }}/{{ $questionnaire->grading()->gradableQuestions() }}  </div>
        </div>
        <div class="grid grid-cols-12">
          <div class="col-span-4 text-black text-opacity-90"> Puntos </div>
          <div class="col-span-8 text-black"> {{ $student->stats()->gradeInQuestionnaire($questionnaire) }} </div>
        </div>
      </div>
    </div>
    <div class="col-span-12 flex flex-col divide-y card">
      <div class="grid grid-cols-12 px-6 py-3 text-black font-medium bg-black  bg-opacity-5 rounded items-center">
        <div class="col-span-1">
          {{ __('P') }}
        </div>
        <div class="col-span-4">
          {{ __('Subtopic') }}
        </div>
        <div class="col-span-5">
          {{ __('Skill') }}
        </div>
        <div class="col-span-1 text-center">
          {{ Str::ucfirst(__('Marca')) }}
        </div>
        <div class="col-span-1 text-center">
          {{ Str::ucfirst(__('right')) }}
        </div>
      </div>
      <div class="py-2">
        @foreach ($questionnaire->questions as $question)
          <div class="grid grid-cols-12 py-3 px-6 hover:bg-gray-100 transition duration-300">
            <div class="col-span-1 my-auto">
              {{ $question->position }}
            </div>
            <div class="col-span-4 text-sm ">
              {{ $question->subtopic->name }}
            </div>
            <div class="col-span-5 text-sm my-auto">
              {{ $question->skill->name }}
            </div>
            <div class="col-span-1 text-center">
              {{ $student->stats()->answerToQuestion($question)->name ?? 'N/A' }}
            </div>
            <div class="col-span-1 text-center">
              {{ $question->alternatives()->where('correct', true)->first()->name }}
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </div>
@endsection
