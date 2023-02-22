@extends('teacher.template.main')

@section('content')
  <x-teacher.container>
    <x-teacher.layout.title-bar
      :name="$questionnaireGroup->name"
      :previus-route="route('teacher.index')"
    ></x-teacher.layout.title-bar>
    <div class="col-span-12">
      <x-teacher.card.card>
        <x-teacher.card.list :divide="false">
          <x-teacher.card.list-key-value :key="__('name')" :value="$questionnaireGroup->name" />
          <x-teacher.card.separator/>
          <x-teacher.card.list-key-value :key="__('answers')" :value="$questionnaireGroup->stats()->getSentCount()" />
        </x-teacher.card.list>
      </x-teacher.card.card>
    </div>
    <div class="col-span-12">
      <x-teacher.card.table>
        <x-slot:header>
          <div class="col-span-3">
            {{ __('questionnaire') }}
          </div>
          <div class="col-span-3">
            {{ __('average score') }}
          </div>
          <div class="col-span-3">
            {{ __('sent count') }}
          </div>
        </x-slot:header>
        @foreach($questionnaireGroup->questionnaires as $questionnaire)
          <a href="{{ route('teacher.questionnaires.show', $questionnaire)}} ">
            <x-teacher.card.table-row>
              <div class="col-span-3">
                {{ $questionnaire->subject->name }}
              </div>
              <div class="col-span-3">
                {{ $questionnaire->stats()->getAverageScore() }}
              </div>
              <div class="col-span-3">
                {{ $questionnaire->stats()->getStudentsSentCount() }}
              </div>
            </x-teacher.card.table-row>
          </a>
        @endforeach
      </x-teacher.card.table>
    </div>
  </x-teacher.container>
@endsection
