@extends('teacher.template.main')

@section('content')
  <x-teacher.container>
    <x-teacher.layout.title-bar :name="__('question')">
      <x-slot:actions>
        <x-teacher.action-button
          form="question-form"
          type="submit"
          :body="__('submit')"
        />
      </x-slot:actions>
    </x-teacher.layout.title-bar>
    <div class="col-span-12">
      <x-teacher.forms.form
        method="POST"
        :action="route('teacher.question-bank.questionnaire-prototypes.store')"
        id="question-form"
      >
        <x-base.card :header="__('information')">
          <x-base.form.list>
            <x-base.form.list.item
              input="select-model"
              :attribute="__('subject')"
              name="subject_id"
              :options="$subjects"
              :value="request()->query('where_subject_id')"
            />
            <x-base.form.list.item
              input="select-model"
              :attribute="__('questionnaire_group')"
              name="questionnaire_group_id"
              :options="$questionnaireGroups"
            />
            <x-base.form.list.item
              input="text"
              :attribute="__('name')"
              name="name"
            />
          </x-base.form.list>
        </x-base.card>
      </x-teacher.forms.form>
    </div>
  </x-teacher.container>
@endsection
