@extends('stats.template.main')

@section('content')
<div class="container mx-auto grid grid-cols-12 p-3 gap-3 text-black text-opacity-90">
  <div class="col-span-12 flex flex-row items-center gap-3">
    <div class="font-medium text-lg p-2 rounded text-opacity-80 text-black items-center flex gap-3">
      <a href="{{ route('stats.questionnaireGroup', $questionnaire->questionnaireGroup) }}">
        <span class="iconify-inline text-xl" data-icon="mdi:arrow-left"></span>
      </a>
      <h3 class="">
        {{ $questionnaire->name }}
      </h3>
    </div>
    <div class="ml-auto"></div>
    <a href="{{ route('stats.questionnaire.students.index', $questionnaire) }}" class="bg-blue-800 rounded p-3 text-white inline-block">
      {{ Str::ucfirst(__('students')) }}
    </a>
  </div>
  <div class="col-span-12 bg-white rounded shadow p-3 flex flex-col gap-3">
    <div class="flex flex-col gap-4 p-3">
      <div class="grid grid-cols-12">
        <div class="col-span-4 text-black text-opacity-90"> Id </div>
        <div class="col-span-8 text-black"> {{ $questionnaire->id }} </div>
      </div>
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
        <div class="col-span-4 text-black text-opacity-90"> {{ __('Average') }} </div>
        <div class="col-span-8 text-black"> {{ round($questionnaire->stats()->average(), 2)*100 }}% - {{ $questionnaire->stats()->averageScore() }} correctas - {{ $questionnaire->stats()->averageGrade() }} puntos</div>
      </div>
      {{--
      <div class="grid grid-cols-12">
        <div class="col-span-4 text-black text-opacity-90"> {{ __('Standart deviation') }} </div>
        <div class="col-span-8 text-black"> {{ $questionnaire->standart_deviation }}</div>
      </div>
      <div class="grid grid-cols-12">
        <div class="col-span-4 text-black text-opacity-90"> {{ __('Skewness') }} </div>
        <div class="col-span-8 text-black"> {{ $questionnaire->skewness }}</div>
      </div>
      <div class="grid grid-cols-12">
        <div class="col-span-4 text-black text-opacity-90"> {{ __('Kurtosis') }} </div>
        <div class="col-span-8 text-black"> {{ $questionnaire->kurtosis }}</div>
      </div>
      <div class="grid grid-cols-12">
        <div class="col-span-4 text-black text-opacity-90"> {{ __('Coefficient of internal consistency') }} </div>
        <div class="col-span-8 text-black"> {{ $questionnaire->coefficient_internal_consistency }}</div>
      </div>
      <div class="grid grid-cols-12">
        <div class="col-span-4 text-black text-opacity-90"> {{ __('Error ratio') }} </div>
        <div class="col-span-8 text-black"> {{ $questionnaire->error_ratio }}</div>
      </div>
      <div class="grid grid-cols-12">
        <div class="col-span-4 text-black text-opacity-90"> {{ __('Standard Error') }} </div>
        <div class="col-span-8 text-black"> {{ $questionnaire->standard_error }}</div>
      </div>
      --}}
    </div>
  </div>
  @foreach($questionnaire->stats()->byTagGroupByTagByDivision() as $tag_group_name => $tag_groups)
    <div class="col-span-12 flex flex-col divide-y card">
      <div class="grid grid-cols-12 px-6 py-3 text-black font-medium bg-black  bg-opacity-5 rounded">
        <div class="col-span-5 my-auto">
          {{ Str::of(__($tag_group_name))->ucfirst() }}
        </div>
        @foreach(range(0, 12-count($divisions)-6) as $c)
          <div class="col-span-1"></div>
        @endforeach
        @foreach($divisions as $division)
          <div class="col-span-1 text-center">
            {{ $division->name }}
          </div>
        @endforeach
      </div>
      <div class="py-2">
        @foreach ($tag_groups as $tag_name => $tags)
          <div class="grid grid-cols-12 py-3 px-6 hover:bg-gray-100 transition duration-300">
            <div class="col-span-5 my-auto">
              {{ Str::of(__($tag_name))->ucfirst() }}
            </div>
            @foreach(range(0, 12-count($divisions)-6) as $c)
              <div class="col-span-1"></div>
            @endforeach
            @foreach ($tags as $stat)
              <div class="col-span-1 text-sm text-center">
                {{ $stat }}
              </div>
            @endforeach
          </div>
        @endforeach
      </div>
    </div>
  @endforeach
  <div class="col-span-12 flex flex-col divide-y card">
    <div class="grid grid-cols-12 px-6 py-3 text-black font-medium bg-black  bg-opacity-5 rounded items-center">
      <div class="col-span-1">
        {{ __('Name') }}
      </div>
      <div class="col-span-3">
        {{ __('Subtopic') }}
      </div>
      <div class="col-span-5">
        {{ __('Skill') }}
      </div>
      <div class="col-span-2 ">
        {{ Str::ucfirst(__('logro')) }}
      </div>
    </div>
    <div class="py-2">
      @foreach ($questionnaire->questions as $question)
        <a class="grid grid-cols-12 py-3 px-6 transition duration-300 items-center {{ $question->pilot ? 'bg-yellow-200 hover:bg-yellow-300' : 'bg-white hover:bg-gray-100' }}" href="{{ route('stats.question', $question) }}">
          <div class="col-span-1 my-auto ">
            {{ $question->position }}
          </div>
          <div class="col-span-3 text-sm ">
            {{ $question->subtopic->name }}
          </div>
          <div class="col-span-5 text-sm my-auto">
            {{ $question->skill->name }}
          </div>
          <div class="col-span-2 my-auto">
            {{ round($question->stats()->averageScore()*100) }}%
          </div>
          <div class="col-span-1 text-sm text-black text-opacity-60 my-auto">
            {{ __('details') }}
          </div>
        </a>
      @endforeach
    </div>
  </div>
</div>
@endsection
