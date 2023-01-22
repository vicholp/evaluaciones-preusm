@extends('teacher.template.main')

@section('content')
  <x-teacher.container>
    <x-teacher.layout.title-bar :name="__('question')">
      <x-slot:actions>
        <x-teacher.action-button
          :href="route('teacher.question-bank.questions.store')"
          form="question-form" type="submit"
          method="POST" :body="__('submit')"
        />
      </x-slot:actions>
    </x-teacher.layout.title-bar>
    <div class="col-span-12">
      <x-teacher.card.card>
        <x-teacher.forms.form method="POST" :action="route('teacher.question-bank.questions.store')">
          <x-teacher.forms.input-select :attribute="__('subject')" name="subject_id" :options="$subjects"/>
          <x-teacher.forms.input-text :attribute="__('name')" name="name"/>
          <x-teacher.forms.input-text :attribute="__('description')" name="description"/>
          <lala></lala>
        </x-teacher.forms.form>
      </x-teacher.card.card>
    </div>
  </x-teacher.container>


@endsection
