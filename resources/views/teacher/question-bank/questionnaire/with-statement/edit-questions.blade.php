@extends('teacher.template.main')

@section('content')
  <x-teacher.container>
    <x-teacher.layout.title-bar :name="__('question')">
      <x-slot:actions>
        <x-teacher.action-button form="question-form" type="submit" :body="__('submit')" />
      </x-slot:actions>
    </x-teacher.layout.title-bar>
    <div class="col-span-12">
      <x-teacher.forms.form method="POST" :action="route('teacher.question-bank.questionnaire-prototypes.store')" id="question-form">
      <teacher-question-bank-questionnaire-edit-statements
        :initial-selected-questions="@json($items)"
        :subject-id="{{ $questionnaire->subject->id }}"
        ></teacher-question-bank-questionnaire-edit-statements>
      </x-teacher.forms.form>
    </div>
  </x-teacher.container>
@endsection
