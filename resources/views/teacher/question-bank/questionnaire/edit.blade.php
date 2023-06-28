@extends('teacher.template.main')

@section('content')
  <x-teacher.container>
    <x-teacher.layout.title-bar
      :name="__('questionnaire') . ' - ' . $questionnaire->latest->name"
      :previus-route="route('teacher.question-bank.questionnaire-prototypes.show', $questionnaire)"
    >
      <x-slot:actions>
        <x-base.action
          form="question-form"
          type="submit"
          :body="__('save')"
          icon="mdi-content-save"
        />
      </x-slot:actions>
    </x-teacher.layout.title-bar>
    <div class="col-span-12">
      <x-teacher.forms.form
        method="PUT"
        :action="route('teacher.question-bank.questionnaire-prototypes.update', $questionnaire)"
        id="question-form"
      >
        <x-teacher.card.card :header="__('information')">
          <div class="flex flex-col gap-3">
            <x-teacher.forms.input-text
              :attribute="__('name')"
              name="name"
              :value="$questionnaire->latest->name"
            />
            <x-teacher.forms.input-text
              :attribute="__('description')"
              name="description"
              :value="$questionnaire->latest->description"
            />
          </div>
        </x-teacher.card.card>
      </x-teacher.forms.form>
    </div>
  </x-teacher.container>
@endsection
