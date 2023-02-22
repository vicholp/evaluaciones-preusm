@extends('teacher.template.main')

@section('content')
  <x-teacher.container>
    <x-teacher.layout.title-bar
      :name="$questionnaire->name"
      :previus-route="route('teacher.questionnaire-groups.show', $questionnaire->questionnaireGroup)"
    >
      <x-slot:actions>
        <a href="{{ route('teacher.questionnaires.show', $questionnaire) }}" class="bg-indigo-800 rounded p-3 text-white inline-block">
          {{ __('by questions') }}
        </a>
      </x-slot:actions>
    </x-teacher.layout.title-bar>
    <div class="col-span-12">
      <x-teacher.card.card>
        <div class="flex flex-col gap-4 p-6">
          <x-teacher.card.list-key-value :key="__('name')" :value="$questionnaire->name"></x-teacher.card.list-key-value>
          <x-teacher.card.separator/>
          <x-teacher.card.list-key-value :key="__('answers')" :value="$questionnaire->stats()->getSentCount()"></x-teacher.card.list-key-value>
          <x-teacher.card.list-key-value :key="__('average score')" :value="$questionnaire->stats()->getAverageScore()"></x-teacher.card.list-key-value>
        </div>
      </x-teacher.card.card>
    </div>
    <div class="col-span-12">
      <x-teacher.card.card>
        <x-slot:header>
          <div class="px-6 py-3 font-medium grid grid-cols-12 bg-black bg-opacity-5 text-black text-opacity-90">
            <div class="col-span-3">
              {{ __('name') }}
            </div>
            <div class="col-span-3">
              {{ __('topic') }}
            </div>
            <div class="col-span-3">
              {{ __('subtopic') }}
            </div>
            <div class="col-span-3">
              {{ __('score') }}
            </div>
          </div>
        </x-slot>
        <div class="flex flex-col py-3">
          @foreach($students as $student)
            <a class="px-6 py-3 grid grid-cols-12 bg-black bg-opacity-0 hover:bg-opacity-5" href="{{ route('teacher.questionnaires.students.show', [$questionnaire, $student])}} ">
              <div class="col-span-3">
                {{ $student->name }}
              </div>
              <div class="col-span-3">
                {{-- {{ $student->stats() }} --}}
              </div>
              <div class="col-span-3">
                {{-- {{ $student }} --}}
              </div>
              <div class="col-span-3">
                {{-- {{ $student }} --}}
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
