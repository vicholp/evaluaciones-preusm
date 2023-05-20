@extends('teacher.template.main')

@section('content')
  <x-base.layout.container>
    <div class="col-span-12">
      @foreach ($questions as $question)
        <teacher-question-bank-questions-dom-to-image
          :body='`{{ Str::replace('\\', '\\\\', $question['item']->body) }}`'
          :title="`{{ str_pad((string)($loop->index + 1), 2, '0', STR_PAD_LEFT) }}`"
          :questionnaire="`{{ $questionnaire->latest->name }}`">

        </teacher-question-bank-questions-dom-to-image>
      @endforeach
    </div>
  </x-base.layout.container>
@endsection
