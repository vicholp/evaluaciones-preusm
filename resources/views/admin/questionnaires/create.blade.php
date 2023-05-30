@extends('admin.template.main')

@section('content')
  <x-base.layout.container>
    <x-base.layout.title-bar :title="__('question')">
      <x-slot:actions>
        <x-base.action
          form="question-form"
          type="submit"
          :body="__('submit')"
        />
      </x-slot:actions>
    </x-base.layout.title-bar>
    <div class="col-span-12">
      <x-base.form
        method="POST"
        :action="route('admin.questionnaires.store')"
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
              required
            />
            <x-base.form.list.item
              input="select-model"
              :attribute="__('questionnaire_group')"
              name="questionnaire_group_id"
              :options="$questionnaireGroups"
              required
            />
            <x-base.form.list.item
              input="text"
              :attribute="__('name')"
              name="name"
            />
            <x-base.form.list.item
              input="text"
              type="number"
              min="0"
              :attribute="__('questions count')"
              value="65"
            />
          </x-base.form.list>
        </x-base.card>
      </x-base.form>
    </div>
  </x-base.layout.container>
@endsection
