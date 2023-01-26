@extends('teacher.template.main')

@section('content')
  <x-teacher.container>
    <x-teacher.layout.title-bar :name="__('questions')">
      <x-slot:actions>
        <x-teacher.action-button :href="route('teacher.question-bank.questions.create')" :body="__('create')"/>
      </x-slot:actions>
    </x-teacher.layout.title-bar>
    <div class="col-span-12">
      <x-teacher.card.card>
        <x-teacher.card.list>
          @foreach ($questions as $question)
            <x-teacher.card.list-element>
              {{ $question->latest->name }}
            </x-teacher.card.list-element>
          @endforeach
        </x-teacher.card.list>
      </x-teacher.card.card>
    </div>
  </x-teacher.container>
@endsection
