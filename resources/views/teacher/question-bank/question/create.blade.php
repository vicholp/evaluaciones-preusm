@extends('teacher.template.main')

@section('content')
  <x-teacher.container>
    <x-teacher.layout.title-bar :name="__('question')">
      <x-slot:actions>
        <x-teacher.action-button form="question-form" type="submit" :body="__('submit')" />
      </x-slot:actions>
    </x-teacher.layout.title-bar>
    <div class="col-span-12">
      <x-teacher.forms.form method="POST" :action="route('teacher.question-bank.question-prototypes.store')" id="question-form">
        <x-teacher.card.card :header="__('information')">
          <div class="flex flex-col gap-3">
            <x-teacher.forms.input-select :attribute="__('subject')" name="subject_id" :options="$subjects"/>
            <x-teacher.forms.input-text :attribute="__('name')" name="name"/>
            <x-teacher.forms.input-text :attribute="__('description')" name="description"/>
          </div>
        </x-teacher.card.card>
        <x-teacher.card.card :header="__('content')">
          <div class="flex flex-col gap-3">
            <quill-js name="body"></quill-js>
            <x-teacher.forms.input-select :attribute="__('answer')" name="answer" :options="['A', 'B', 'C', 'D', 'E']"/>
          </div>
        </x-teacher.card.card>
        <x-teacher.card.card :header="__('tags')">
          <div class="flex flex-col gap-3">
            <x-teacher.forms.input-vue-multiselect :attribute="__('item type')" name="tags" :options="['a', 'b', 'c']" />
            <x-teacher.forms.input-vue-multiselect :attribute="__('skill')" name="tags" :options="['a', 'b', 'c']" />
            <x-teacher.forms.input-vue-multiselect :attribute="__('topic')" name="tags" :options="['a', 'b', 'c']" />
            <x-teacher.forms.input-vue-multiselect :attribute="__('subtopic')" name="tags" :options="['a', 'b', 'c']" />
          </div>
        </x-teacher.card.card>
      </x-teacher.forms.form>
    </div>
  </x-teacher.container>


@endsection
