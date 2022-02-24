@extends('admin.template.main')

@section('content')
  <div class="container mx-auto grid grid-cols-12 p-3 gap-3">
    <div class="col-span-12 flex flex-row items-center gap-3">
      <div class="font-medium text-lg p-2 rounded inline-block text-opacity-80 text-black">
        divisions - {{ $divisions->count() }}
      </div>
      <div class="ml-auto"></div>
      <a href="{{ route('admin.divisions.create') }}" class="bg-indigo-800 rounded p-3 text-white inline-block">
        Create
      </a>
    </div>
    <div class="col-span-12 flex flex-col divide-y card">
      <div class="grid grid-cols-12 px-6 py-3 text-black font-medium bg-black  bg-opacity-5 rounded">
        <div class="col-span-1">
          ID
        </div>
        <div class="col-span-7">
          Name
        </div>
        <div class="col-span-2">
          Start Date
        </div>
        <div class="col-span-2">
          End Date
        </div>
      </div>
      <div class="p-3">
        @foreach ($divisions as $division)
        <a class="grid grid-cols-12 p-3" href="{{ route('admin.divisions.show', $division) }}">
          <div class="col-span-1">
            {{ $division->id }}
          </div>
          <div class="col-span-7">
            {{ $division->name }}
          </div>
          <div class="col-span-2">
            {{ $division->start_date }}
          </div>
          <div class="col-span-2">
            {{ $division->end_date }}
          </div>
        </a>
        @endforeach
      </div>
    </div>
  </div>
@endsection
