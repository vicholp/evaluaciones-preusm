@extends('teacher.template.main')

@section('content')
  <x-base.layout.container>
    <div class="col-span-12">

      {{-- <questions-tiptap
        version-id="{{ App\Models\QuestionPrototype::find(154)->latest->id }}"
        attribute="body"
      >
      </questions-tiptap> --}}
      <v-tiptap version-id="{{ App\Models\QuestionPrototype::find(154)->latest->id }}">
      </v-tiptap>

      <v-tiptap
        version-id="{{ App\Models\QuestionPrototype::find(154)->latest->id }}"
        attribute="solution"
      >
      </v-tiptap>

      <v-tiptap content="askdfjaksjdf">
      </v-tiptap>

      {{-- <teacher-question-bank-questions-tiptap
        initial-content="{{ \App\Models\QuestionPrototype::find(154)->latest->body }}"
      >
      </teacher-question-bank-questions-tiptap>
      <teacher-question-bank-questions-tiptap
        :initial-content="`{{ \App\Models\QuestionPrototype::find(154)->latest->body }}`"
      >
      </teacher-question-bank-questions-tiptap> --}}
    </div>

    {{-- @dd(\App\Models\QuestionPrototypeVersion::find(170)->body) --}}
  </x-base.layout.container>
@endsection
