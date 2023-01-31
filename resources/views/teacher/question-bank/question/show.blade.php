@extends('teacher.template.main')

@section('content')
  <x-teacher.container>
    <x-teacher.layout.title-bar :name="__('questions')">
      <x-slot:actions>
        <x-teacher.action-button :href="route('teacher.question-bank.question-prototypes.edit', $question)" :body="__('edit')"/>
      </x-slot:actions>
    </x-teacher.layout.title-bar>
    <div class="col-span-12">
      <x-teacher.card.card>
        <x-teacher.card.list :divide="false">
          <x-teacher.card.row key="name" :value="$question->latest->name"/>
          <x-teacher.card.row key="description" :value="$question->latest->description"/>
          <x-teacher.card.row key="body" :value="$question->latest->body" secure="true"/>
          <x-teacher.card.row key="answer" :value="$question->latest->answer"/>
        </x-teacher.card.list>
      </x-teacher.card.card>
    </div>
  </x-teacher.container>
@endsection
