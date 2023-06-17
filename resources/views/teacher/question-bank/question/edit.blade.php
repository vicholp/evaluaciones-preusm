@extends('teacher.template.main')

@section('content')
  <x-teacher.container>
    <x-teacher.layout.title-bar
      :name="__('edit question')"
      :previus-route="route('teacher.question-bank.question-prototypes.show', [$question, 'where_subject_id' => request()->query('where_subject_id')])"
    >
      <x-slot:actions>
        <x-teacher.action-button
          form="question-form" type="submit" :body="__('edit')"
        />
      </x-slot:actions>
    </x-teacher.layout.title-bar>
    <div class="col-span-12">
      <x-teacher.forms.form method="PUT" :action="route('teacher.question-bank.question-prototypes.update', $question)" id="question-form">
        <x-teacher.card.card :header="__('information')">
          <div class="flex flex-col gap-3">
            <x-teacher.forms.input-text :attribute="__('subject')" :value="$question->subject->name" disabled/>
            <x-teacher.forms.input-text :attribute="__('name')" name="name" :value="$question->latest->name"/>
            <x-teacher.forms.input-text :attribute="__('description')" name="description" :value="$question->latest->description"/>
          </div>
        </x-teacher.card.card>
        <x-teacher.card.card :header="__('content')">
          <div class="flex flex-col gap-3">
            <questions-tiptap
              :version-id="{{ $question->latest->id }}"
              name="body"
              class="mx-auto"
            >
            </questions-tiptap>
          </div>
        </x-teacher.card.card>
        <x-teacher.card.card :header="__('solution')">
          <div class="flex flex-col gap-3">
            <x-teacher.forms.input-select :attribute="__('answer')" name="answer" :value="$question->latest->answer" :options="['A', 'B', 'C', 'D', 'E']"/>
            <teacher-question-bank-questions-tiptap
              :initial-content="`{{ Str::replace('\\', '\\\\', $question->latest->solution) }}`"
              name="solution"
              class="mx-auto"
            >
            </teacher-question-bank-questions-tiptap>
          </div>
        </x-teacher.card.card>
        <x-teacher.card.card :header="__('tags')">
          <div class="flex flex-col gap-3">
            @foreach($tagGroups as $tagGroup)
              <x-teacher.forms.input :attribute="__($tagGroup->name)">
                <div class="col-span-8">
                  <teacher-question-bank-quesitons-multiselect-tags name="tags[]" :options='@json($tags[$tagGroup->id])' :value='@json($selectedTags[$tagGroup->name])'>
                  </teacher-question-bank-quesitons-multiselect-tags>
                </div>
              </x-teacher.forms.input>
            @endforeach
          </div>
        </x-teacher.card.card>
      </x-teacher.forms.form>
    </div>
  </x-teacher.container>
@endsection
