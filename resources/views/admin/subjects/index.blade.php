@extends('admin.template.main')

@section('content')
  <div class="container mx-auto grid grid-cols-12 p-3 gap-3">
    <div class="col-span-12 flex flex-row items-center gap-3">
      <div class="font-medium text-lg p-2 rounded inline-block text-opacity-80 text-black">
        subjects - {{ $subjects->count() }}
      </div>
      <div class="ml-auto"></div>
      <a href="{{ route('admin.subjects.create') }}" class="bg-indigo-800 rounded p-3 text-white inline-block">
        Create
      </a>
    </div>
    <div class="col-span-12 flex flex-col divide-y card">
      <div class="grid grid-cols-12 px-6 py-3 text-black font-medium bg-black  bg-opacity-5 rounded">
        <div class="col-span-1">
          ID
        </div>
        <div class="col-span-11">
          Name
        </div>
      </div>
      <div class="p-3">
        @foreach ($subjects as $subject)
        <a class="grid grid-cols-12 p-3" href="{{ route('admin.subjects.show', $subject) }}">
          <div class="col-span-1">
            {{ $subject->id }}
          </div>
          <div class="col-span-11">
            {{ $subject->name }}
          </div>
        </a>
        @endforeach
      </div>
    </div>
  </div>
@endsection
