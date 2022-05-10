@extends('admin.template.main')

@section('content')
<div class="container mx-auto grid grid-cols-12 p-3 gap-3 text-black text-opacity-90">
  <div class="col-span-12 flex flex-row items-center gap-3">
    <div class="font-medium text-lg p-2 rounded text-opacity-80 text-black items-center flex gap-3">
      <a href="{{ route('stats.questionnaire', $question->questionnaire) }}">
        <span class="iconify-inline text-xl" data-icon="mdi:arrow-left"></span>
      </a>
      <h3 class="">
        {{ __('question') }} {{ $question->name }}
      </h3>
    </div>
    <div class="ml-auto"></div>
  </div>
  <div class="col-span-12 bg-white rounded shadow p-3 flex flex-col gap-3">
    <div class="flex flex-col gap-4 p-3">
      <div class="grid grid-cols-12">
        <div class="col-span-4 text-black text-opacity-90"> id </div>
        <div class="col-span-8 text-black"> {{ $question->id }} </div>
      </div>
      <div class="grid grid-cols-12">
        <div class="col-span-4 text-black text-opacity-90"> {{ __('Name') }} </div>
        <div class="col-span-8 text-black"> {{ $question->name }} </div>
      </div>
      <div class="grid grid-cols-12">
        <div class="col-span-4 text-black text-opacity-90"> {{ __('Questionnaire') }} </div>
        <div class="col-span-8 text-black"> {{ $question->questionnaire->name }} {{ $question->questionnaire->subject->name }} {{ $question->questionnaire->period->name }}</div>
      </div>
      <div class="h-[1px] w-full bg-gray-100 rounded">
      </div>
      <div class="grid grid-cols-12">
        <div class="col-span-4 text-black text-opacity-90"> {{ Str::ucfirst(__('pilot')) }} </div>
        <div class="col-span-8 text-black"> {{ $question->pilot ? 'Si' : 'No' }}</div>
      </div>
      <div class="grid grid-cols-12">
        <div class="col-span-4 text-black text-opacity-90"> {{ __('Answers') }} </div>
        <div class="col-span-8 text-black"> {{ $question->answers }}</div>
      </div>
      <div class="grid grid-cols-12">
        <div class="col-span-4 text-black text-opacity-90"> {{ __('Facility index') }} </div>
        <div class="col-span-8 text-black flex items-center gap-2">
          {{ $question->facility_index }}
          @if($question->facility_index_score)
            <span class="iconify text-yellow-400 text-xl" data-icon="ic:round-warning-amber"></span>
            <span class="text-yellow-600 text-sm">esta pregunta puede ser muy facil o muy dificil</span>
            @endif
          </div>
        </div>
        <div class="grid grid-cols-12">
          <div class="col-span-4 text-black text-opacity-90"> {{ __('Standart deviation') }} </div>
          <div class="col-span-8 text-black"> {{ $question->standart_deviation }}</div>
        </div>
        <div class="grid grid-cols-12">
          <div class="col-span-4 text-black text-opacity-90"> {{ __('Random guess score') }} </div>
          <div class="col-span-8 text-black flex items-center gap-2">
            {{ $question->random_guess_score }}
            @if($question->random_guess_score_score)
            <span class="iconify text-yellow-400 text-xl" data-icon="ic:round-warning-amber"></span>
            <span class="text-yellow-600 text-sm"></span>
            @endif
          </div>
        </div>
        <div class="grid grid-cols-12">
          <div class="col-span-4 text-black text-opacity-90"> {{ __('Intended weight') }} </div>
          <div class="col-span-8 text-black"> {{ $question->intended_weight }}</div>
        </div>
        <div class="grid grid-cols-12">
          <div class="col-span-4 text-black text-opacity-90"> {{ __('Effective weight') }} </div>
          <div class="col-span-8 text-black flex items-center gap-2">
            {{ $question->effective_weight }}
            @if($question->effective_weight_score)
            <span class="iconify text-yellow-400 text-xl" data-icon="ic:round-warning-amber"></span>
            <span class="text-yellow-600 text-sm">Esta pregunta puede evaluar algo diferente al resto de preguntas.</span>
            @endif
          </div>
        </div>
        <div class="grid grid-cols-12">
          <div class="col-span-4 text-black text-opacity-90"> {{ __('Discrimination index') }} </div>
          <div class="col-span-8 text-black flex items-center gap-2">
            {{ $question->discrimination_index }}
            @if($question->discrimination_index_score)
            <span class="iconify text-yellow-400 text-xl" data-icon="ic:round-warning-amber"></span>
            <span class="text-yellow-600 text-sm">Esta pregunta puede no lograr discriminar correctamente a los estudiantes.</span>
            @endif
          </div>
        </div>
        <div class="grid grid-cols-12">
          <div class="col-span-4 text-black text-opacity-90"> {{ __('Discrimination efficiency') }} </div>
          <div class="col-span-8 text-black flex items-center gap-2">
            {{ $question->discrimination_efficiency }}
            @if($question->discrimination_efficiency_score)
            <span class="iconify text-yellow-400 text-xl" data-icon="ic:round-warning-amber"></span>
            <span class="text-yellow-600 text-sm">Esta pregunta puede no lograr discriminar correctamente a los estudiantes.</span>
          @endif
        </div>
      </div>
      <div class="h-[1px] w-full bg-gray-100 rounded">
      </div>
      <div class="grid grid-cols-12">
        <div class="col-span-4 text-black text-opacity-90"> {{ __('Topic') }} </div>
        <div class="col-span-8 text-black"> {{ $question->topic->name }}</div>
      </div>
      <div class="grid grid-cols-12">
        <div class="col-span-4 text-black text-opacity-90"> {{ __('Subtopic') }} </div>
        <div class="col-span-8 text-black"> {{ $question->subtopic->name }}</div>
      </div>
      <div class="grid grid-cols-12">
        <div class="col-span-4 text-black text-opacity-90"> {{ __('Item type') }} </div>
        <div class="col-span-8 text-black"> {{ $question->item_type->name }}</div>
      </div>
      <div class="grid grid-cols-12">
        <div class="col-span-4 text-black text-opacity-90"> {{ __('Skill') }} </div>
        <div class="col-span-8 text-black"> {{ $question->skill->name }}</div>
      </div>
    </div>
  </div>
  <div class="col-span-12 flex flex-col divide-y card">
    <div class="grid grid-cols-12 px-6 py-3 text-black font-medium bg-black  bg-opacity-5 rounded items-center">
      <div class="col-span-5">
        Paralelo
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
      <div class="grid grid-cols-12 py-3 px-6 hover:bg-gray-100 transition duration-300">
        <div class="col-span-5 my-auto">
          {{ Str::of(__('average'))->ucfirst() }}
        </div>
        @foreach(range(0, 12-count($divisions)-6) as $c)
          <div class="col-span-1"></div>
        @endforeach
        @foreach($stats as $stat)
          <div class="col-span-1 text-center">
            {{ $stat }}
          </div>
        @endforeach
        </div>
    </div>
  </div>
  <div class="col-span-12 flex flex-col divide-y card">
    <div class="grid grid-cols-12 px-6 py-3 text-black font-medium bg-black  bg-opacity-5 rounded">
      <div class="col-span-1">
        {{ __('Name') }}
      </div>
      <div class="col-span-10">
        {{ __('Answers') }}
      </div>
      <div class="col-span-1 text-center">
        %
      </div>
    </div>
    <div class="p-3">
      @if($question->with_alternatives)
        @foreach ($question->alternatives()->where('position', '>=', 0)->get() as $alternative)
          <div @class([
              'grid grid-cols-12 p-3 rounded',
              'bg-emerald-500' => $alternative->correct,
              'bg-gray-100' => $alternative->name == 'N/A',
              ])>
            <div class="col-span-1">
              {{ $alternative->name }}
            </div>
            <div class="col-span-10">
              {{ $alternative->students->count() }}
            </div>
            <div class="col-span-1 text-center">
              {{ round($alternative->students->count() / $question->answers * 100,2) }}%
            </div>
          </div>
        @endforeach
      @else
        @foreach ($question->alternatives()->where('position','<=', 0)->get() as $alternative)
          <div @class([
              'grid grid-cols-12 p-3 rounded',
              'bg-emerald-500' => $alternative->correct,
              'bg-gray-100' => $alternative->name == 'N/A',
              ])>
            <div class="col-span-1">
              {{ __($alternative->name) }}
            </div>
            <div class="col-span-10">
              {{ $alternative->students->count() }}
            </div>
            <div class="col-span-1 text-center">
              {{ round($alternative->students->count() / $question->answers * 100,2) }}%
            </div>
          </div>
        @endforeach
      @endif
    </div>
  </div>
  <div class="col-span-12 flex-col divide-y card hidden">
    <div class="grid grid-cols-12 px-6 py-3 text-black font-medium bg-black  bg-opacity-5 rounded">
      <div class="col-span-1">
        Division
      </div>
      <div class="col-span-9">
        Answers
      </div>
      <div class="col-span-1">
        %
      </div>
    </div>
    <div class="p-3">
    </div>
  </div>
</div>
@endsection
