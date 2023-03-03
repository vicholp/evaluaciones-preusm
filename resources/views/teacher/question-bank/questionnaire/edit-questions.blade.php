@extends('teacher.template.main')

@section('content')
  <x-teacher.container>
    <x-teacher.layout.title-bar :name="__('question')">
      <x-slot:actions>
        <x-teacher.action-button form="question-form" type="submit" :body="__('submit')" />
      </x-slot:actions>
    </x-teacher.layout.title-bar>
    <div class="col-span-12">
      <x-teacher.forms.form method="PUT" :action="route('teacher.question-bank.questionnaire-prototypes.update-questions', $questionnaire)" id="question-form">
        <input type="text" name="with_questions" value="1" hidden>
        <teacher-question-bank-questionnaire-edit-questions
          :questionnaire-id="{{ $questionnaire->id }}"
          :subject-id="{{ $questionnaire->subject->id }}"
          ></teacher-question-bank-questionnaire-edit-questions>
        </x-teacher.forms.form>
    </div>
  </x-teacher.container>
@endsection
