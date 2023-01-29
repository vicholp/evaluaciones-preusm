@extends('teacher.template.main')

@section('content')
  <x-teacher.container>
    <x-teacher.layout.title-bar :name="__('question')">
      <x-slot:actions>
        <x-teacher.action-button
          form="question-form" type="submit" :body="__('submit')"
        />
      </x-slot:actions>
    </x-teacher.layout.title-bar>
    <div class="col-span-12">
      <x-teacher.card.card>
        <x-teacher.forms.form method="POST" :action="route('teacher.question-bank.question-prototypes.store')" id="question-form">
          <x-teacher.forms.input-select :attribute="__('subject')" name="subject_id" :options="$subjects"/>
          <x-teacher.forms.input-text :attribute="__('name')" name="name"/>
          <x-teacher.forms.input-text :attribute="__('description')" name="description"/>
          <quilljs name="body"></quilljs>
          <x-teacher.forms.input-select :attribute="__('answer')" name="answer" :options="['A', 'B', 'C', 'D', 'E']"/>
        </x-teacher.forms.form>
      </x-teacher.card.card>
    </div>
  </x-teacher.container>


@endsection
