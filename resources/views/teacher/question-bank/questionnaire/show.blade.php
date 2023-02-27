@extends('teacher.template.main')

@section('content')
  <x-teacher.container>
    <x-teacher.layout.title-bar
      :name="__('questionnaires')"
      :previus-route="route('teacher.question-bank.questionnaire-prototypes.index')"
    >
      <x-slot:actions>
        <x-teacher.action-button :href="route('teacher.question-bank.questionnaire-prototypes.edit', $questionnaire)" :body="__('edit')"/>
      </x-slot:actions>
    </x-teacher.layout.title-bar>
    <div class="col-span-12">
      <x-teacher.card.card>
        <x-teacher.card.list :divide="false">
          <x-teacher.card.list-key-value :key="__('name')" :value="$questionnaire->latest->name"/>
          <x-teacher.card.list-key-value :key="__('subject')" :value="$questionnaire->subject->name"/>
          <x-teacher.card.list-key-value :key="__('description')" :value="$questionnaire->latest->description"/>
        </x-teacher.card.list>
      </x-teacher.card.card>
    </div>
    <div class="col-span-12">
      <x-teacher.card.card :header="__('questions')">
        <x-teacher.card.list :divide="false">
          @foreach ($questionsSorted as $index => $question)
          <a href="{{ route('teacher.question-bank.question-prototypes.show', $question) }}">
            <x-teacher.card.list-item>
              {{ $index+1 }} - {{ $question->latest->name }}
            </x-teacher.card.list-item>
          </a>
          @endforeach
        </x-teacher.card.list>
      </x-teacher.card.card>
    </div>
  </x-teacher.container>
@endsection
