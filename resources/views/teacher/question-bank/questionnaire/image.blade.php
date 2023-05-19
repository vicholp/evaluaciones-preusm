@extends('teacher.template.main')

@section('content')
  <x-base.layout.container>
    <div class="col-span-12">
      @foreach ($questions as $question)
        <teacher-question-bank-questions-dom-to-image :body='`{{ Str::replace('\\', '\\\\', $question->body) }}`'>
        </teacher-question-bank-questions-dom-to-image>
      @endforeach
    </div>
  </x-base.layout.container>
@endsection
