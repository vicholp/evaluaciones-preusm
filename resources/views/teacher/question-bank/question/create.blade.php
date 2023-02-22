@extends('teacher.template.main')

@section('content')
  <x-teacher.container>
    <x-teacher.layout.title-bar
      :name="__('new question')"
      :previus-route="route('teacher.question-bank.question-prototypes.index', ['where_subject_id' => request()->query('where_subject_id')])"
    >
      <x-slot:actions>
        <x-teacher.action-button
          form="question-form" type="submit" :body="__('create')"
        />
      </x-slot:actions>
    </x-teacher.layout.title-bar>
    <div class="col-span-12">
      <x-teacher.forms.form method="POST" :action="route('teacher.question-bank.question-prototypes.store')" id="question-form">
        <x-teacher.card.card :header="__('information')">
          <div class="flex flex-col gap-3">
            <x-teacher.forms.input-select :attribute="__('subject')" name="subject_id" :options="$subjects" :value="request()->query('where_subject_id')"/>
            <x-teacher.forms.input-text :attribute="__('name')" name="name"/>
            <x-teacher.forms.input-text :attribute="__('description')" name="description"/>
          </div>
        </x-teacher.card.card>
        <x-teacher.card.card :header="__('content')">
          <div class="flex flex-col gap-3">
            <teacher-question-bank-questions-tiptap-editor
              name="body"
            >
            </teacher-question-bank-questions-tiptap-editor>
          </div>
        </x-teacher.card.card>
        <x-teacher.card.card :header="__('solution')">
          <div class="flex flex-col gap-3">
            <x-teacher.forms.input-select :attribute="__('answer')" name="answer" :options="['A', 'B', 'C', 'D', 'E']"/>
            <teacher-question-bank-questions-tiptap-editor name="solution">
            </teacher-question-bank-questions-tiptap-editor>
          </div>
        </x-teacher.card.card>
        <x-teacher.card.card :header="__('tags')">
          <div class="flex flex-col gap-3">
            @foreach($tags as $tag)
              <x-teacher.forms.input :attribute="__($tag->name)">
                <div class="col-span-8">
                  <teacher-question-bank-quesitons-multiselect-tags name="tags[]" :options='@json($tag->tags)' ></teacher-question-bank-quesitons-multiselect-tags>
                </div>
              </x-teacher.forms.input>
            @endforeach
          </div>
        </x-teacher.card.card>
      </x-teacher.forms.form>
    </div>
  </x-teacher.container>
@endsection
