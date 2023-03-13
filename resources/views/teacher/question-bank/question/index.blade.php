@extends('teacher.template.main')

@section('content')
  <x-teacher.container>
    <x-teacher.layout.title-bar
      :name="__('question bank') . ' - ' . __('questions')"
      :previus-route="route('teacher.question-bank.index')"
    >
      <x-slot:actions>
        <x-teacher.action-button :href="route('teacher.question-bank.question-prototypes.create', ['where_subject_id' => request()->query('where_subject_id')])"
          :body="__('new') . ' ' . __('question')"
        />
        @if ($showCreateStatement)
          <x-teacher.action-button :href="route('teacher.question-bank.statement-prototypes.create', ['where_subject_id' => request()->query('where_subject_id')])"
            :body="__('new') . ' ' . __('statement')"
          />
        @endif
      </x-slot:actions>
    </x-teacher.layout.title-bar>
    <div class="col-span-12">
      <x-teacher.card.card>
        <x-teacher.card.list>
          @foreach ($questions as $question)
            <a href="{{ route('teacher.question-bank.question-prototypes.show', [$question, 'where_subject_id' => request()->query('where_subject_id')]) }}">
              <x-teacher.card.list-item>
                @if($question->latest?->name)
                  <span> {{ $question->latest?->name }} </span>
                @else
                  <questions-tiptap-mini :initial-content="`{{ $question->latest?->body }}`" />
                @endif
              </x-teacher.card.list-item>
            </a>
          @endforeach
        </x-teacher.card.list>
      </x-teacher.card.card>
    </div>
  </x-teacher.container>
@endsection
