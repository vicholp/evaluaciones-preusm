@extends('teacher.template.main')

@section('content')
  <x-teacher.container>
    <x-teacher.layout.title-bar
      :name="__('question bank') . ' - ' . __('questions')"
      :previus-route="route('teacher.question-bank.index')"
    >
      <x-slot:actions>
        <x-teacher.action-button :href="route('teacher.question-bank.question-prototypes.create')" :body="__('create')"/>
      </x-slot:actions>
    </x-teacher.layout.title-bar>
    <div class="col-span-12">
      <x-teacher.card.card>
        <x-teacher.card.list>
          @foreach ($questions as $question)
            <a href="{{ route('teacher.question-bank.question-prototypes.show', $question) }}">
              <x-teacher.card.list-element>
                {{ $question->latest?->name ?? "sin nombre"}}
              </x-teacher.card.list-element>
            </a>
          @endforeach
        </x-teacher.card.list>
      </x-teacher.card.card>
    </div>
  </x-teacher.container>
@endsection
