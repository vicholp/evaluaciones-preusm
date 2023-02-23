@extends('teacher.template.main')

@section('content')
  <x-teacher.container>
    <x-teacher.layout.title-bar
      :name="__('questions')"
      :previus-route="route('teacher.question-bank.question-prototypes.index', ['where_subject_id' => request()->query('where_subject_id')])"
    >
      <x-slot:actions>
        <x-teacher.action-button :href="route('teacher.question-bank.statement-prototypes.edit', $statement)" :body="__('edit')"/>
      </x-slot:actions>
    </x-teacher.layout.title-bar>
    <div class="col-span-12">
      <x-teacher.card.card>
        <x-teacher.card.list :divide="false">
          <x-teacher.card.list-key-value :key="__('subject')" :value="$statement->subject->name"/>
          <x-teacher.card.list-key-value :key="__('name')" :value="$statement->name"/>
          <x-teacher.card.list-key-value :key="__('description')" :value="$statement->description"/>
        </x-teacher.card.list>
      </x-teacher.card.card>
    </div>
    <div class="col-span-12">
      <x-teacher.card.card :header="__('content')">
        <div class="flex justify-center">
          <teacher-question-bank-statement-tiptap-text-readonly
            :initial-content="`{{ $statement->body }}`"
            >
          </teacher-question-bank-statement-tiptap-text-readonly>
        </div>
      </x-teacher.card.card>
    </div>
    <div class="col-span-12">
      <x-teacher.card.card :header="__('questions')">
        <x-teacher.card.list>
          @foreach ($statement->questions as $question)
            <a href="{{ route('teacher.question-bank.question-prototypes.show', $question) }}">
              <x-teacher.card.list-item>
                {{ $question->latest->name }}
              </x-teacher.card.list-item>
            </a>
          @endforeach
        </x-teacher.card.list>
      </x-teacher.card.card>
    </div>
  </x-teacher.container>
@endsection
