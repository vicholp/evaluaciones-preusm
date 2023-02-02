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
            @foreach($tags as $tag)
              <x-teacher.forms.input-vue-multiselect :attribute="__($tag->name)" name="tags_{{ $tag->name }}" :options="$tag->tags->only('name')" />
            @endforeach
          </div>
        </x-teacher.card.card>
      </x-teacher.forms.form>
    </div>
  </x-teacher.container>


@endsection
