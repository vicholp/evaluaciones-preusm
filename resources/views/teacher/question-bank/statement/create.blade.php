@extends('teacher.template.main')

@section('content')
  <x-teacher.container>
    <x-teacher.layout.title-bar
      :name="__('create') . ' ' . __('statement')"
      :previus-route="route('teacher.question-bank.statement-prototypes.index', ['where_subject_id' => request()->query('where_subject_id')])"
    >
      <x-slot:actions>
        <x-teacher.action-button
          form="statement-form" type="submit" :body="__('create')"
        />
      </x-slot:actions>
    </x-teacher.layout.title-bar>
    <div class="col-span-12">
      <x-teacher.forms.form method="POST" :action="route('teacher.question-bank.statement-prototypes.store')" id="statement-form">
        <x-teacher.card.card :header="__('information')">
          <div class="flex flex-col gap-3">
            <x-teacher.forms.input-select :attribute="__('subject')" name="subject_id" :options="$subjects" :value="request()->query('where_subject_id')"/>
            <x-teacher.forms.input-text :attribute="__('name')" name="name" />
            <x-teacher.forms.input-text :attribute="__('description')" name="description" />
          </div>
        </x-teacher.card.card>
        <x-teacher.card.card :header="__('content')">
          <div class="flex gap-3 justify-center">
            <teacher-question-bank-statement-tiptap-text
              name="body"
            >
            </teacher-question-bank-statement-tiptap-text>
          </div>
        </x-teacher.card.card>
      </x-teacher.forms.form>
    </div>
  </x-teacher.container>
@endsection
