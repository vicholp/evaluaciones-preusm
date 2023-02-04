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
        <x-teacher.card.card :header="__('information')">
          <div class="flex flex-col gap-3">
            <x-teacher.forms.input-select :attribute="__('subject')" name="subject_id" :options="$subjects" :value="request()->query('where_subject_id')"/>
            <x-teacher.forms.input-text :attribute="__('name')" name="name"/>
            <x-teacher.forms.input-text :attribute="__('description')" name="description"/>
          </div>
        </x-teacher.card.card>
      <teacher-question-bank-questionnaire-edit-questions></teacher-question-bank-questionnaire-edit-questions>
      </x-teacher.forms.form>
    </div>
  </x-teacher.container>
@endsection
