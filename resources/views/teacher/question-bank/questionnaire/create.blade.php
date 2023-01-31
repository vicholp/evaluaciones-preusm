@extends('teacher.template.main')

@section('content')
  <x-teacher.container>
    <x-teacher.layout.title-bar :name="__('questionnaires')">
      <x-slot:actions>
        <x-teacher.action-button
          type="submit"
          form="questionnaire-form"
          :body="__('create')"/>
      </x-slot:actions>
    </x-teacher.layout.title-bar>
    <div class="col-span-12">
      <x-teacher.card.card>
        <x-teacher.card.list>
          @foreach ($questionnaires as $questionnaire)
            <x-teacher.card.list-element>
              <a href="{{ route('teacher.question-bank.questionnaire-prototypes.show', $questionnaire)}} ">
                {{ $questionnaire->latest?->name ?? "sin nombre"}}
              </a>
            </x-teacher.card.list-element>
          @endforeach
        </x-teacher.card.list>
      </x-teacher.card.card>
    </div>
  </x-teacher.container>
@endsection
