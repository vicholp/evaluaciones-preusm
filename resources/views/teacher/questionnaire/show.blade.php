@extends('teacher.template.main')

@section('content')
  <x-teacher.container>
    <x-teacher.layout.title-bar
      :name="$questionnaire->name"
      :previus-route="route('teacher.questionnaire-groups.show', $questionnaire->questionnaireGroup)"
    ></x-teacher.layout.title-bar>
    <div class="col-span-12">
      <x-teacher.card.card>
        <div class="flex flex-col gap-4 p-6">
          <x-teacher.card.element :key="__('name')" :value="$questionnaire->name"></x-teacher.card.element>
          <x-teacher.card.separator/>
          <x-teacher.card.element :key="__('answers')" :value="$questionnaire->stats()->getSentCount()"></x-teacher.card.element>
          <x-teacher.card.element :key="__('average score')" :value="$questionnaire->stats()->getAverageScore()"></x-teacher.card.element>
        </div>
      </x-teacher.card.card>
    </div>
    <div class="col-span-12">
      <x-teacher.card.card>
        <x-slot:header>
          <div class="px-6 py-3 font-medium grid grid-cols-12 bg-black bg-opacity-5 text-black text-opacity-90">
            <div class="col-span-3">
              {{ __('questionnaire') }}
            </div>
            <div class="col-span-3">
              {{ __('topic') }}
            </div>
            <div class="col-span-3">
              {{ __('subtopic') }}
            </div>
            <div class="col-span-3">
              {{ __('correct answers') }}
            </div>
          </div>
        </x-slot>
        <div class="flex flex-col py-3">
          @foreach($questionnaire->questions as $question)
            <a class="px-6 py-3 grid grid-cols-12 bg-black bg-opacity-0 hover:bg-opacity-5" href="{{ route('teacher.questions.show', $question)}} ">
              <div class="col-span-3">
                {{ $question->position }}
              </div>
              <div class="col-span-3">
                {{ $question->topic->name }}
              </div>
              <div class="col-span-3">
                {{ $question->subtopic->name }}
              </div>
              <div class="col-span-3">
                {{ $question->stats()->getAverageScore() }}
              </div>
              <div class="col-span-3">
                {{-- {{ $questionnaire->stats()->getStudentsSentCount() }} --}}
              </div>
            </a>
          @endforeach
        </div>
      </x-teacher.card.card>
    </div>
  </x-teacher.container>
@endsection
