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
        <x-teacher.forms.form method="PUT" :action="route('teacher.question-bank.question-prototypes.update', $question)" id="question-form">
          <x-teacher.forms.input-text :attribute="__('name')" name="name" value="{{ $question->latest->name }}"/>
          <x-teacher.forms.input-text :attribute="__('description')" name="description" value="{{ $question->latest->description}}"/>
          <quilljs name="body" start-value="{{ $question->latest->body }}"></quilljs>
          <x-teacher.forms.input-select :attribute="__('answer')" name="answer" :model="$question" :options="['A', 'B', 'C', 'D', 'E']"/>
        </x-teacher.forms.form>
      </x-teacher.card.card>
    </div>
  </x-teacher.container>
@endsection
