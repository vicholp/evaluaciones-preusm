@extends('admin.template.main')

@section('content')
<div class="container mx-auto grid grid-cols-12 p-3 gap-3 text-black text-opacity-90">
  <div class="col-span-12 flex flex-row items-center gap-3">
    <div class="font-medium text-lg p-2 rounded text-opacity-80 text-black items-center flex gap-3">
      <a href="{{ route('admin.questionnaires.show', $question->questionnaire) }}">
        <span class="iconify-inline text-xl" data-icon="mdi:arrow-left"></span>
      </a>
      <h3 class="">
        {{ $question->name }}
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
        <div class="col-span-4 text-black text-opacity-90"> name </div>
        <div class="col-span-8 text-black"> {{ $question->name }} </div>
      </div>
      <div class="grid grid-cols-12">
        <div class="col-span-4 text-black text-opacity-90"> questionnaire </div>
        <div class="col-span-8 text-black"> {{ $question->questionnaire->name }} {{ $question->questionnaire->subject->name }} {{ $question->questionnaire->period->name }}</div>
      </div>
      <div class="h-[1px] w-full bg-gray-100 rounded">
      </div>
      <div class="grid grid-cols-12">
        <div class="col-span-4 text-black text-opacity-90"> pilot </div>
        <div class="col-span-8 text-black"> {{ $question->pilot }}</div>
      </div>
      <div class="grid grid-cols-12">
        <div class="col-span-4 text-black text-opacity-90"> answers </div>
        <div class="col-span-8 text-black"> {{ $question->answers }}</div>
      </div>
      <div class="grid grid-cols-12">
        <div class="col-span-4 text-black text-opacity-90"> facility_index </div>
        <div class="col-span-8 text-black"> {{ $question->facility_index }}</div>
      </div>
      <div class="grid grid-cols-12">
        <div class="col-span-4 text-black text-opacity-90"> standart_deviation </div>
        <div class="col-span-8 text-black"> {{ $question->standart_deviation }}</div>
      </div>
      <div class="grid grid-cols-12">
        <div class="col-span-4 text-black text-opacity-90"> random_guess_score </div>
        <div class="col-span-8 text-black"> {{ $question->random_guess_score }}</div>
      </div>
      <div class="grid grid-cols-12">
        <div class="col-span-4 text-black text-opacity-90"> intended_weight </div>
        <div class="col-span-8 text-black"> {{ $question->intended_weight }}</div>
      </div>
      <div class="grid grid-cols-12">
        <div class="col-span-4 text-black text-opacity-90"> discrimination_index </div>
        <div class="col-span-8 text-black"> {{ $question->discrimination_index }}</div>
      </div>
      <div class="grid grid-cols-12">
        <div class="col-span-4 text-black text-opacity-90"> discrimination_efficiency </div>
        <div class="col-span-8 text-black"> {{ $question->discrimination_efficiency }}</div>
      </div>
      <div class="h-[1px] w-full bg-gray-100 rounded">
      </div>
      <div class="grid grid-cols-12">
        <div class="col-span-4 text-black text-opacity-90"> topic </div>
        <div class="col-span-8 text-black"> {{ $question->topic->name }}</div>
      </div>
      <div class="grid grid-cols-12">
        <div class="col-span-4 text-black text-opacity-90"> subtopic </div>
        <div class="col-span-8 text-black"> {{ $question->subtopic->name }}</div>
      </div>
      <div class="grid grid-cols-12">
        <div class="col-span-4 text-black text-opacity-90"> item type </div>
        <div class="col-span-8 text-black"> {{ $question->item_type->name }}</div>
      </div>
      <div class="grid grid-cols-12">
        <div class="col-span-4 text-black text-opacity-90"> skill </div>
        <div class="col-span-8 text-black"> {{ $question->skill->name }}</div>
      </div>
    </div>
  </div>
  <div class="col-span-12 flex flex-col divide-y card">
    <div class="grid grid-cols-12 px-6 py-3 text-black font-medium bg-black  bg-opacity-5 rounded">
      <div class="col-span-1">
        Name
      </div>
      <div class="col-span-9">
        Answers
      </div>
      <div class="col-span-1">
        %
      </div>
    </div>
    <div class="p-3">
      @foreach ($question->alternatives as $alternative)
        <div @class([
            'grid grid-cols-12 p-3 rounded',
            'bg-emerald-500' => $alternative->correct,
            'bg-gray-100' => $alternative->name == 'N/A',
            ])>
          <div class="col-span-1">
            {{ $alternative->name }}
          </div>
          <div class="col-span-9">
            {{ $alternative->students->count() }}
          </div>
          <div class="col-span-1">
          </div>
        </div>
      @endforeach
    </div>
  </div>
  <div class="col-span-12 flex flex-col divide-y card hidden">
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
