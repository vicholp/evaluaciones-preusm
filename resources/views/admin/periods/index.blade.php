@extends('admin.template.main')

@section('content')
  <div class="container mx-auto grid grid-cols-12 p-3 gap-3">
    <div class="col-span-12 flex flex-row items-center gap-3">
      <div class="font-medium text-lg p-2 rounded inline-block text-opacity-80 text-black">
        periods - {{ $periods->count() }}
      </div>
      <div class="ml-auto"></div>
      <a href="{{ route('admin.periods.create') }}" class="bg-indigo-800 rounded p-3 text-white inline-block">
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
        @foreach ($periods as $period)
        <a class="grid grid-cols-12 p-3" href="{{ route('admin.periods.show', $period) }}">
          <div class="col-span-1">
            {{ $period->id }}
          </div>
          <div class="col-span-7">
            {{ $period->name }}
          </div>
          <div class="col-span-2">
            {{ $period->start_date }}
          </div>
          <div class="col-span-2">
            {{ $period->end_date }}
          </div>
        </a>
        @endforeach
      </div>
    </div>
  </div>
@endsection
