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
          <x-teacher.card.list-key-value :key="__('subject')" :value="$question->subject->name"/>
          @if ($question->statement)
            <x-teacher.card.list-key-value :key="__('statement')"
              :value="$question->statement?->name"
              :link="route('teacher.question-bank.statement-prototypes.show', $question->statement)"
            />
          @endif
          <x-teacher.card.list-key-value :key="__('name')" :value="$question->latest->name"/>
          <x-teacher.card.list-key-value :key="__('description')" :value="$question->latest->description"/>
          <x-teacher.card.list-key-value :key="__('tags')">
            <x-slot:value>
              <div class="flex flex-wrap gap-2">
                @forelse ($question->latest->tags as $tag)
                  <div class="rounded py-1 px-2 bg-black bg-opacity-5 dark:bg-white dark:bg-opacity-5 text-sm">
                    {{ __($tag->tagGroup->name) }}: {{ $tag->name }}
                  </div>
                @empty
                  <div class="rounded py-1 px-2 bg-black bg-opacity-5 dark:bg-white dark:bg-opacity-5 text-sm">
                    <i>
                      {{ __('without tags') }}
                    </i>
                  </div>
                @endforelse
              </div>
            </x-slot:value>
          </x-teacher.card.list-key-value>
          <x-teacher.card.list-key-value :key="__('version')" :value="$question->latest->index"/>
        </x-teacher.card.list>
      </x-teacher.card.card>
    </div>
    <div class="col-span-12">
      <x-teacher.card.card :header="__('content')">
        <div class="flex justify-center">
          <teacher-question-bank-questions-tiptap
            :initial-content="`{{ Str::replace('\\', '\\\\', $question->latest->body) }}`"
            :editable="false"
          >
          </teacher-question-bank-questions-tiptap>
        </div>
      </x-teacher.card.card>
    </div>
    <div class="col-span-12">
      <x-teacher.card.card :header="__('solution')">
        <div class="flex justify-center">
          <teacher-question-bank-questions-tiptap
            :initial-content="`{{ Str::replace('\\', '\\\\', $question->latest->solution) ?? __('<i>without solution</i>') }}`"
            :editable="false"
          >
          </teacher-question-bank-questions-tiptap>
        </div>
        <div class="mt-3"></div>
        <x-teacher.card.list :divide="false">
          <x-teacher.card.list-key-value :key="__('answer')" :value="$question->latest->answer"/>
        </x-teacher.card.list>
      </x-teacher.card.card>
    </div>
  </x-teacher.container>
@endsection
