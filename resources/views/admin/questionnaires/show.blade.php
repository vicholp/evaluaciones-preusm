@extends('admin.template.main')

@section('content')
<div class="container mx-auto grid grid-cols-12 p-3 gap-3 text-black text-opacity-90">
  <div class="col-span-12 flex flex-row items-center gap-3">
    <div class="font-medium text-lg p-2 rounded text-opacity-80 text-black items-center flex gap-3">
      <a href="{{ route('admin.questionnaires.index') }}">
        <span class="iconify-inline text-xl" data-icon="mdi:arrow-left"></span>
      </a>
      <h3 class="">
        {{ $questionnaire->name }}
      </h3>
    </div>
    <div class="ml-auto"></div>
    <a href="{{ route('admin.questionnaires.upload-results', $questionnaire) }}" class="bg-blue-800 rounded p-3 text-white inline-block">
      Upload results
    </a>
    <a href="{{ route('stats.questionnaire', $questionnaire) }}" class="bg-blue-800 rounded p-3 text-white inline-block">
      See stats
    </a>
    <a href="{{ route('admin.questionnaire.compute-stats', $questionnaire) }}" class="bg-indigo-800 rounded p-3 text-white inline-block">
      Compute Stats
    </a>
    <a href="{{ route('admin.questionnaires.edit', $questionnaire) }}" class="bg-blue-800 rounded p-3 text-white inline-block">
      Edit
    </a>
    <form action="{{ route('admin.questionnaires.destroy', $questionnaire) }}" method="POST" hidden id="form-delete">
      @csrf
      @METHOD('DELETE')
    </form>
    <button type="submit" form="form-delete" class="bg-red-800 rounded p-3 text-white inline-block">
      Remove
    </button>
  </div>
  <div class="col-span-12 bg-white rounded shadow p-3 flex flex-col gap-3">
    <div class="flex flex-col gap-4 p-3">
      <div class="grid grid-cols-12">
        <div class="col-span-4 text-black text-opacity-90"> id </div>
        <div class="col-span-8 text-black"> {{ $questionnaire->id }} </div>
      </div>
      <div class="grid grid-cols-12">
        <div class="col-span-4 text-black text-opacity-90"> name </div>
        <div class="col-span-8 text-black"> {{ $questionnaire->name }} </div>
      </div>
      <div class="grid grid-cols-12">
        <div class="col-span-4 text-black text-opacity-90"> subject </div>
        <div class="col-span-8 text-black"> {{ $questionnaire->subject->name }} </div>
      </div>
      <div class="grid grid-cols-12">
        <div class="col-span-4 text-black text-opacity-90"> questionnaire group </div>
        <div class="col-span-8 text-black"> {{ $questionnaire->questionnaireGroup->name }} </div>
      </div>
    </div>
  </div>
  <div class="col-span-12 flex flex-col divide-y card">
    <div class="grid grid-cols-12 px-6 py-3 text-black font-medium bg-black  bg-opacity-5 rounded">
      <div class="col-span-1">
        Name
      </div>
      <div class="col-span-1">
        Red flags
      </div>
      <div class="col-span-2">
        Eje
      </div>
      <div class="col-span-3">
        Contenido
      </div>
      <div class="col-span-3">
        Habilidad
      </div>
      <div class="col-span-2">
        Tipo de item
      </div>
    </div>
    <div class="p-3">
      @foreach ($questionnaire->questions as $question)
        <a class="grid grid-cols-12 p-3" href="{{ route('admin.questions.show', $question) }}">
          <div class="col-span-1">
            {{ $question->position }}
          </div>
          <div class="col-span-1">
            {{ $question->full_score }} / 5
          </div>
          <div class="col-span-2 text-sm">
            {{ $question->tags()->whereTagGroupId(1)->first()->name ?? '' }}
          </div>
          <div class="col-span-3 text-sm">
            {{ $question->tags()->whereTagGroupId(2)->first()->name ?? '' }}
          </div>
          <div class="col-span-3 text-sm">
            {{ $question->tags()->whereTagGroupId(3)->first()->name ?? '' }}
          </div>
          <div class="col-span-2 text-sm">
            {{ $question->tags()->whereTagGroupId(4)->first()->name ?? ''}}
          </div>
        </a>
      @endforeach
    </div>
  </div>

</div>
@endsection
