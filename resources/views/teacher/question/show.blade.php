@extends('teacher.template.main')

@section('content')
  <x-teacher.container>
    <x-teacher.layout.title-bar
      :name="$question->name"
      :previus-route="route('teacher.questionnaires.show', $question->questionnaire)"
    ></x-teacher.layout.title-bar>
    <div class="col-span-12">
      <x-teacher.card.card>
        <div class="flex flex-col gap-4 p-6">
          <x-teacher.card.element :key="__('name')" :value="$question->name"></x-teacher.card.element>
          <x-teacher.card.element :key="__('skill')" :value="$question->skill?->name ?? 'n/a'"></x-teacher.card.element>
          <x-teacher.card.element :key="__('topic')" :value="$question->topic?->name  ?? 'n/a'"></x-teacher.card.element>
          <x-teacher.card.element :key="__('subtopic')" :value="$question->subtopic?->name ?? 'n/a'"></x-teacher.card.element>
          <x-teacher.card.element :key="__('item type')" :value="$question->itemType?->name  ?? 'n/a'"></x-teacher.card.element>
          <x-teacher.card.separator/>
          {{-- <x-teacher.card.element :key="__('answers')" :value="$question->stats()->getAnswersCount()"></x-teacher.card.element> --}}
        </div>
      </x-teacher.card.card>
    </div>
    <div class="col-span-12 flex flex-col gap-3">
      <x-teacher.card.card>
        <x-slot:header>
          <div class="px-6 py-3 font-medium grid grid-cols-12 bg-black bg-opacity-5 text-black text-opacity-90">
            <div class="col-span-3">
              {{ __('alternative') }}
            </div>
            <div class="col-span-3">
              {{ __('answers') }}
            </div>
          </div>
        </x-slot>
        <div class="flex flex-col py-3">
          @foreach($question->alternatives as $alternative)
            <div @class([
                  'px-6 py-3 grid grid-cols-12',
                  'bg-black bg-opacity-0 hover:bg-opacity-5'
            ])>
              <div class="col-span-3">
                {{ $alternative->name }}
              </div>
              <div class="col-span-3">
                {{ $alternative->students->count() }}
              </div>
              <div class="col-span-6 flex ">
                <div class="ml-auto"></div>
                  @if ($alternative->correct)
                    <div class="text-green-500 text-opacity-100 font-medium">
                      correcta
                    </div>
                  @endif
              </div>
            </div>
          @endforeach
        </div>
      </x-teacher.card.card>
      <x-teacher.card.card>
        <x-slot:header>
          <div class="px-6 py-3 font-medium grid grid-cols-12 bg-black bg-opacity-5 text-black text-opacity-90">
            <div class="col-span-3">
              {{ __('student') }}
            </div>
            <div class="col-span-3">
              {{ __('answer') }}
            </div>
            <div class="col-span-3">
              {{ __('score in questionnaire') }}
            </div>
          </div>
        </x-slot>
        <div class="flex flex-col py-3">
          @foreach($question->students as $student)
            <a class="px-6 py-3 grid grid-cols-12 bg-black bg-opacity-0 hover:bg-opacity-5"
              href="{{ route('teacher.questionnaires.students.show', [$question->questionnaire, $student])}}"
            >
              <div class="col-span-3">
                {{ $student->user->name }}
              </div>
              <div class="col-span-3">
                {{ $student->pivot->alternative->name }}
              </div>
              <div class="col-span-3">
                {{ $student->stats()->getScoreInQuestionnaire($question->questionnaire) }}
              </div>
            </a>
          @endforeach
        </div>
      </x-teacher.card.card>
    </div>
  </x-teacher.container>
@endsection
