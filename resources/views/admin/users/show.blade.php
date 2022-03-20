@extends('admin.template.main')

@section('content')
<div class="container mx-auto grid grid-cols-12 p-3 gap-3 text-black text-opacity-90">
  <div class="col-span-12 flex flex-row items-center gap-3">
    <div class="font-medium text-lg p-2 rounded text-opacity-80 text-black items-center flex gap-3">
      <a href="{{ route('admin.users.index') }}">
        <span class="iconify-inline text-xl" data-icon="mdi:arrow-left"></span>
      </a>
      <h3 class="">
        {{ $user->name }}
      </h3>
    </div>
    <div class="ml-auto"></div>
    @if ($user->kind === 'student')
      <a href="{{ route('students.index', $user) }}" class="bg-blue-800 rounded p-3 text-white inline-block">
        View as student
      </a>
    @endif
    <a href="{{ route('admin.users.edit', $user) }}" class="bg-blue-800 rounded p-3 text-white inline-block">
      Edit
    </a>
  </div>
  <div class="col-span-12 bg-white rounded shadow p-3 flex flex-col gap-3">
    <div class="flex flex-col gap-4 p-3">
      <div class="grid grid-cols-12">
        <div class="col-span-4 text-black text-opacity-90"> id </div>
        <div class="col-span-8 text-black"> {{ $user->id }} </div>
      </div>
      <div class="grid grid-cols-12">
        <div class="col-span-4 text-black text-opacity-90"> name </div>
        <div class="col-span-8 text-black"> {{ $user->name }} </div>
      </div>
      <div class="grid grid-cols-12">
        <div class="col-span-4 text-black text-opacity-90"> rut </div>
        <div class="col-span-8 text-black"> {{ $user->rut }} </div>
      </div>
      <div class="grid grid-cols-12">
        <div class="col-span-4 text-black text-opacity-90"> email </div>
        <div class="col-span-8 text-black"> {{ $user->email }} </div>
      </div>
      <div class="grid grid-cols-12">
        <div class="col-span-4 text-black text-opacity-90"> kind </div>
        <div class="col-span-8 text-black"> {{ $user->kind }} </div>
      </div>
    </div>
  </div>
  @if ($user->kind === 'student')
    <div class="col-span-12 flex flex-col divide-y card">
      <div class="grid grid-cols-12 px-6 py-3 text-black font-medium bg-black  bg-opacity-5 rounded">
        <div class="col-span-1">
          ID
        </div>
        <div class="col-span-5">
          Name
        </div>
        <div class="col-span-4">
          Subject
        </div>
        <div class="col-span-2">
          Grade
        </div>
      </div>
      <div class="p-3">
        @foreach ($questionnaires as $questionnaire)
          <a class="grid grid-cols-12 p-3">
            <div class="col-span-1">
              {{ $questionnaire->id }}
            </div>
            <div class="col-span-5">
              {{ $questionnaire->name }}
            </div>
            <div class="col-span-4">
              {{ $questionnaire->subject->name }}
            </div>
            <div>
              {{ $user->student->score($questionnaire) }}
            </div>
          </a>
        @endforeach
      </div>
    </div>
  @endif
</div>
@endsection
