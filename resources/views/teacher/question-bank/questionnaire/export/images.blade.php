@extends('teacher.template.main')

@section('content')
  <x-base.layout.container>
    <div class="col-span-12">
      <teacher-question-bank-questionnaires-to-images :ids="{{ $questions->pluck('item.id') }}">
      </teacher-question-bank-questionnaires-to-images>
    </div>
  </x-base.layout.container>
@endsection
