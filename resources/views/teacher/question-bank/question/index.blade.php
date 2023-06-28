@extends('teacher.template.main')

@section('content')
  <x-teacher.container>
    <x-base.layout.title-bar
      :title="__('question bank') . ' - ' . __('questions')"
      :previus-route="route('teacher.question-bank.index')"
    >
      <x-slot:actions>
        @if ($whereSubject)
          <x-base.pill :body="$whereSubject->name" />
        @endif
        <x-base.action
          :href="route('teacher.question-bank.question-prototypes.create', [
              'where_subject_id' => request()->query('where_subject_id'),
          ])"
          :body="__('create :name', ['name' => __('question')])"
          icon="mdi-plus"
        />
        @if ($showCreateStatement)
          <x-teacher.action-button
            :href="route('teacher.question-bank.statement-prototypes.create', [
                'where_subject_id' => request()->query('where_subject_id'),
            ])"
            :body="__('new') . ' ' . __('statement')"
          />
        @endif
      </x-slot:actions>
    </x-base.layout.title-bar>
    <div class="col-span-12">
      <x-base.card>
        <x-base.list>
          @foreach ($questions as $question)
            <a
              href="{{ route('teacher.question-bank.question-prototypes.show', [
                  $question,
                  'where_subject_id' => request()->query('where_subject_id'),
              ]) }}"
              class="flex"
            >
              @if ($question->latest?->name)
                <x-base.list.item>
                  <span> {{ $question->latest?->name }} </span>
                </x-base.list.item>
              @else
                <div class="py-4">
                  <questions-tiptap-mini :version-id="`{{ $question->latest?->id }}`" />
                </div>
              @endif
            </a>
          @endforeach
        </x-base.list>
      </x-base.card>
    </div>
  </x-teacher.container>
@endsection
