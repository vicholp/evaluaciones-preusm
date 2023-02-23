@extends('teacher.template.main')

@section('content')
  <x-teacher.container>
    <x-teacher.layout.title-bar
      :name="__('edit question')"
      :previus-route="route('teacher.question-bank.statement-prototypes.show', [$statement, 'where_subject_id' => request()->query('where_subject_id')])"
    >
      <x-slot:actions>
        <x-teacher.action-button
          form="statement-form" type="submit" :body="__('edit')"
        />
      </x-slot:actions>
    </x-teacher.layout.title-bar>
    <div class="col-span-12">
      <x-teacher.forms.form method="PUT" :action="route('teacher.question-bank.statement-prototypes.update', $statement)" id="statement-form">
        <x-teacher.card.card :header="__('information')">
          <div class="flex flex-col gap-3">
            <x-teacher.forms.input-text :attribute="__('subject')" :value="$statement->subject->name" disabled/>
            <x-teacher.forms.input-text :attribute="__('name')" name="name" :value="$statement->name"/>
            <x-teacher.forms.input-text :attribute="__('description')" name="description" :value="$statement->description"/>
          </div>
        </x-teacher.card.card>
        <x-teacher.card.card :header="__('content')">
          <div class="flex gap-3 justify-center">
            <teacher-question-bank-statement-tiptap-text-editor
              :initial-content="`{{ $statement->body }}`"
              name="body">
            </teacher-question-bank-statement-tiptap-text-editor>
          </div>
        </x-teacher.card.card>
      </x-teacher.forms.form>
    </div>
  </x-teacher.container>
@endsection
