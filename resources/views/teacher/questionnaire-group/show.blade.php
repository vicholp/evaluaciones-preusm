@extends('teacher.template.main')

@section('content')
  <x-teacher.container>
    <x-teacher.layout.title-bar
      :name="$questionnaireGroup->name"
      :previus-route="route('teacher.index')"
    ></x-teacher.layout.title-bar>
    <div class="col-span-12">
      <x-teacher.card.card>
        <div class="flex flex-col gap-4">
          <x-teacher.card.element key="Name" :value="$questionnaireGroup->name"></x-teacher.card.element>
          <x-teacher.card.separator/>
          <x-teacher.card.element :key="__('answers')" :value="$questionnaireGroup->stats()->getSentCount()"></x-teacher.card.element>
        </div>
      </x-teacher.card.card>
    </div>
    <div class="col-span-12">
      <x-teacher.card.card>
        <x-slot:header>
          <div class="px-6 py-3 font-medium grid grid-cols-12 text-black text-opacity-90">
            <div class="col-span-3">
              {{ __('questionnaire') }}
            </div>
            <div class="col-span-3">
              {{ __('average score') }}
            </div>
            <div class="col-span-3">
              {{ __('sent count') }}
            </div>
          </div>
        </x-slot>
        <div class="flex flex-col py-3">
          @foreach($questionnaireGroup->questionnaires as $questionnaire)
            <a class="px-6 py-3 grid grid-cols-12 bg-black bg-opacity-0 hover:bg-opacity-5" href="{{ route('teacher.questionnaires.show', $questionnaire)}} ">
              <div class="col-span-3">
                {{ $questionnaire->subject->name }}
              </div>
              <div class="col-span-3">
                {{ $questionnaire->stats()->getAverageScore() }}
              </div>
              <div class="col-span-3">
                {{ $questionnaire->stats()->getStudentsSentCount() }}
              </div>
            </a>
          @endforeach
        </div>
      </x-teacher.card.card>
    </div>
  </x-teacher.container>
@endsection
