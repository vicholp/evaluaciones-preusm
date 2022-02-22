@extends('admin.template.main')

@section('content')
<div class="container mx-auto grid grid-cols-12 p-3 gap-3 text-black text-opacity-90">
  <div class="col-span-12 flex flex-row items-center gap-3">
    <div class="font-medium text-lg p-2 rounded text-opacity-80 text-black items-center flex gap-3">
      <a href="{{ route('admin.questionnaire-groups.index') }}">
        <span class="iconify-inline text-xl" data-icon="mdi:arrow-left"></span>
      </a>
      <h3 class="">
        {{ $questionnaireGroup->name }}
      </h3>
    </div>
    <div class="ml-auto"></div>
    <a href="{{ route('admin.questionnaire-groups.edit', $questionnaireGroup) }}" class="bg-blue-800 rounded p-3 text-white inline-block">
      Edit
    </a>
    <form action="{{ route('admin.questionnaire-groups.destroy', $questionnaireGroup) }}" method="POST" hidden id="form-delete">
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
        <div class="col-span-8 text-black"> {{ $questionnaireGroup->id }} </div>
      </div>
      <div class="grid grid-cols-12">
        <div class="col-span-4 text-black text-opacity-90"> name </div>
        <div class="col-span-8 text-black"> {{ $questionnaireGroup->name }} </div>
      </div>
      <div class="grid grid-cols-12">
        <div class="col-span-4 text-black text-opacity-90"> period name </div>
        <div class="col-span-8 text-black"> {{ $questionnaireGroup->period->name }} </div>
      </div>
      <div class="grid grid-cols-12">
        <div class="col-span-4 text-black text-opacity-90"> start_date </div>
        <div class="col-span-8 text-black"> {{ $questionnaireGroup->start_date }} </div>
      </div>
      <div class="grid grid-cols-12">
        <div class="col-span-4 text-black text-opacity-90"> end_date </div>
        <div class="col-span-8 text-black"> {{ $questionnaireGroup->end_date }} </div>
      </div>
    </div>
  </div>
</div>
@endsection
