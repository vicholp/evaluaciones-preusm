@extends('admin.template.main')

@section('content')
  <div class="container mx-auto grid grid-cols-12 p-3 gap-3 text-black text-opacity-90">
    <div class="col-span-12 flex flex-row items-center gap-3">
      <div class="font-medium text-lg p-2 rounded text-opacity-80 text-black items-center flex gap-3">
        <a href="{{ route('admin.questionnaires.index') }}">
          <span class="iconify-inline text-xl" data-icon="mdi:arrow-left"></span>
        </a>
        <h3 class="">
          upload results for {{ $questionnaire->name }}
        </h3>
      </div>
      <div class="ml-auto"></div>
      <button form="form-questionaire" type="submit" class="bg-blue-800 rounded p-3 text-white inline-block">
        Upload
      </button>
    </div>
    @if ($errors->any())
      <div class="bg-red-200 p-3 col-span-12 rounded">
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif
    <div class="col-span-12 bg-white rounded shadow p-3 flex flex-col gap-3">
      <form action="{{ route('admin.questionnaires.import-results', $questionnaire) }}" method="POST" id="form-questionaire" enctype="multipart/form-data">
        @csrf
        <div class="flex flex-col gap-4 p-3">
          <div class="grid grid-cols-12 items-center">
            <div class="col-span-4 text-black text-opacity-90">file with answers</div>
            <input type="file" name="file_answers" class="col-span-8 rounded h-full" required>
          </div>
          <div class="grid grid-cols-12 items-center">
            <div class="col-span-4 text-black text-opacity-90">file with stats</div>
            <input type="file" name="file_stats" class="col-span-8 rounded h-full" required>
          </div>
          <div class="grid grid-cols-12 items-center">
            <div class="col-span-4 text-black text-opacity-90">file with tags</div>
            <input type="file" name="file_tags" class="col-span-8 rounded h-full" required>
          </div>
        </div>

      </form>
    </div>
  </div>
@endsection
