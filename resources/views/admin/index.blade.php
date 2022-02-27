@extends('admin.template.main')

@section('content')
<div class="container mx-auto">
  <div class="grid grid-cols-12 p-3 gap-3">
    <a href="{{ route('admin.users.index') }}" class="bg-white shadow rounded p-3 flex items-center justify-center col-span-3">
      Users
    </a>
    <a href="{{ route('admin.periods.index') }}" class="bg-white shadow rounded p-3 flex items-center justify-center col-span-3">
      Periods
    </a>
    <a href="{{ route('admin.questionnaire-groups.index') }}" class="bg-white shadow rounded p-3 flex items-center justify-center col-span-3">
      Questionnaire Groups
    </a>
    <a href="{{ route('admin.subjects.index') }}" class="bg-white shadow rounded p-3 flex items-center justify-center col-span-3">
      Subjects
    </a>
    <a href="{{ route('admin.study-plans.index') }}" class="bg-white shadow rounded p-3 flex items-center justify-center col-span-3">
      Study Plans
    </a>
    <a href="{{ route('admin.divisions.index') }}" class="bg-white shadow rounded p-3 flex items-center justify-center col-span-3">
      Divisions
    </a>
    <a href="{{ route('admin.questionnaires.index') }}" class="bg-white shadow rounded p-3 flex items-center justify-center col-span-3">
      Questionnaires
    </a>
  </div>
</div>
@endsection
