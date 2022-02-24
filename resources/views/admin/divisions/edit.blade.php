@extends('admin.template.main')

@section('content')
  <div class="container mx-auto grid grid-cols-12 p-3 gap-3 text-black text-opacity-90">
    <div class="col-span-12 flex flex-row items-center gap-3">
      <div class="font-medium text-lg p-2 rounded text-opacity-80 text-black items-center flex gap-3">
        @isset($division)
          <a href="{{ route('admin.divisions.show', $division) }}">
        @else
          <a href="{{ route('admin.divisions.index') }}">
        @endif
          <span class="iconify-inline text-xl" data-icon="mdi:arrow-left"></span>
        </a>
        <h3 class="">
          {{ $division->name ?? 'new division'}}
        </h3>
      </div>
      <div class="ml-auto"></div>
      <a class="bg-gray-200 rounded p-3 text-black inline-block">
        Discard
      </a>
      <button form="form-division" type="submit" class="bg-blue-800 rounded p-3 text-white inline-block">
        Save
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
      @isset($division)
        <form action="{{ route('admin.divisions.update', $division) }}" method="POST" id="form-division">
        @method('PATCH')
      @else
          <form action="{{ route('admin.divisions.store') }}" method="POST" id="form-division">
      @endisset
        @csrf
        <div class="flex flex-col gap-4 p-3">
          <div class="grid grid-cols-12 items-center">
            <div class="col-span-4 text-black text-opacity-90"> name </div>
            <input type="text" class="col-span-8 rounded h-full" name="name" value="{{ $division->name ?? '' }}" required>
          </div>
          <div class="grid grid-cols-12 items-center">
            <div class="col-span-4 text-black text-opacity-90"> subject </div>
            <select type="text" class="col-span-8 rounded h-full" name="subject_id" required>
              @foreach ($subjects as $subject)
                <option value="{{ $subject->id }}" {{ (isset($division) && $division->subject->id == $subject->id) ? 'selected' : '' }}>{{ $subject->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="grid grid-cols-12 items-center">
            <div class="col-span-4 text-black text-opacity-90"> period </div>
            <select type="text" class="col-span-8 rounded h-full" name="period_id" required>
              @foreach ($periods as $period)
                <option value="{{ $period->id }}" {{ (isset($division) && $division->period->id == $period->id) ? 'selected' : '' }}>{{ $period->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="grid grid-cols-12 items-center">
            <div class="col-span-4 text-black text-opacity-90"> study plan </div>
            <select type="text" class="col-span-8 rounded h-full" name="study_plan_id" required>
              @foreach ($studyPlans as $studyPlan)
                <option value="{{ $studyPlan->id }}" {{ (isset($division) && $division->studyPlan->id == $studyPlan->id) ? 'selected' : '' }}>{{ $studyPlan->name }}</option>
              @endforeach
            </select>
          </div>
        </div>
      </form>
    </div>
  </div>
@endsection
