@extends('teacher.template.main')

@section('content')
  <x-base.layout.container>
    <x-teacher.layout.title-bar
      :name="__('manual upload') . ' - revision'"
    >
      <x-slot:actions>
        <x-base.action :href="route('teacher.question-bank.questionnaire-prototypes.index',
          ['where_subject_id' => $questionnairePrototype->subject->id])"
        >
          Confirmar
        </x-base.action>
      </x-slot:actions>
    </x-teacher.layout.title-bar>
    <div class="col-span-12">
      <x-base.card :header="__('questions')">
        <x-utils.card.list>
          @foreach ($latest->questions as $question)
            <x-utils.card.list-item>
              @if($question->parent->name)
                <div> {{ $question->parent->name }} </div>
              @else
                <questions-tiptap-mini :initial-content="`{{ $question->body }}`" />
              @endif
            </x-utils.card.list-item>
            @endforeach
        </x-utils.card.list>
      </x-base.card>
    </div>
  </x-base.layout.container>
@endsection
