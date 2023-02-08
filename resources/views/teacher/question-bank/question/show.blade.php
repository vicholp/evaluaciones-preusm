@extends('teacher.template.main')

@section('content')
  <x-teacher.container>
    <x-teacher.layout.title-bar
      :name="__('questions')"
      :previus-route="route('teacher.question-bank.question-prototypes.index', ['where_subject_id' => request()->query('where_subject_id')])"
    >
      <x-slot:actions>
        <x-teacher.action-button :href="route('teacher.question-bank.question-prototypes.edit', $question)" :body="__('edit')"/>
      </x-slot:actions>
    </x-teacher.layout.title-bar>
    <div class="col-span-12">
      <x-teacher.card.card>
        <x-teacher.card.list :divide="false">
          <x-teacher.card.row :key="__('subject')" :value="$question->subject->name"/>
          <x-teacher.card.row :key="__('name')" :value="$question->latest->name"/>
          <x-teacher.card.row :key="__('description')" :value="$question->latest->description"/>
          <x-teacher.card.row :key="__('tags')">
            <x-slot:value>
              <div class="flex flex-wrap gap-2">
                @foreach ($question->latest->tags as $tag)
                  <div class="rounded py-1 px-2 bg-black bg-opacity-5 dark:bg-white dark:bg-opacity-5 text-sm">
                    {{ $tag->name }}
                  </div>
                @endforeach
              </div>
            </x-slot:value>
          </x-teacher.card.row>
        </x-teacher.card.list>
      </x-teacher.card.card>
    </div>
    <div class="col-span-12">
      <x-teacher.card.card :header="__('content')">
        <teacher-question-bank-questions-tiptap-readonly
          :initial-content="`{{ $question->latest->body }}`"
        >
        </teacher-question-bank-questions-tiptap-readonly>
      </x-teacher.card.card>
    </div>
    <div class="col-span-12">
      <x-teacher.card.card :header="__('solution')">
        <teacher-question-bank-questions-tiptap-readonly
          :initial-content="`{{ $question->latest->solution ?? __('<i>without solution</i>') }}`"
        >
        </teacher-question-bank-questions-tiptap-readonly>
        <div class="mt-3"></div>
        <x-teacher.card.list :divide="false">
          <x-teacher.card.row :key="__('answer')" :value="$question->latest->answer"/>
        </x-teacher.card.list>
      </x-teacher.card.card>
    </div>
  </x-teacher.container>
@endsection
