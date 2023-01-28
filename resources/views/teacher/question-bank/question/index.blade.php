@extends('teacher.template.main')

@section('content')
  <x-teacher.container>
    <x-teacher.layout.title-bar :name="__('questions')">
      <x-slot:actions>
        <x-teacher.action-button :href="route('teacher.question-bank.question-prototypes.create')" :body="__('create')"/>
      </x-slot:actions>
    </x-teacher.layout.title-bar>
    <div class="col-span-12">
      <x-teacher.card.card>
        <x-teacher.card.list>
          @foreach ($questions as $question)
            <x-teacher.card.list-element>
              <a href="{{ route('teacher.question-bank.question-prototypes.show', $question)}} ">
                {{ $question->latest?->name ?? "sin nombre"}}
              </a>
            </x-teacher.card.list-element>
          @endforeach
        </x-teacher.card.list>
      </x-teacher.card.card>
    </div>
  </x-teacher.container>
@endsection
