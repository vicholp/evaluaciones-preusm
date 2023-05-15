@extends('teacher.template.main')

@section('content')
  <x-teacher.container>
    <x-teacher.layout.title-bar
      :name="__('question bank') . ' - ' . __('questionnaires')"
      :previus-route="route('teacher.question-bank.index')"
    >
      <x-slot:actions>
        <x-teacher.action-button
          :href="route('teacher.question-bank.manual-upload.start', ['where_subject_id' => request()->query('where_subject_id')])"
          :body="__('manual upload')"
        />
        <x-teacher.action-button :href="route('teacher.question-bank.questionnaire-prototypes.create', ['where_subject_id' => request()->query('where_subject_id')])" :body="__('new')"/>
      </x-slot:actions>
    </x-teacher.layout.title-bar>
    <div class="col-span-12">
      <x-teacher.card.card>
        <x-teacher.card.list>
          @foreach ($questionnaires as $questionnaire)
            <a href="{{ route('teacher.question-bank.questionnaire-prototypes.show', [$questionnaire, 'where_subject_id' => request()->query('where_subject_id')])}} ">
              <x-teacher.card.list-item>
                {{ $questionnaire->latest?->name ?? "sin nombre"}}
              </x-teacher.card.list-item>
            </a>
          @endforeach
        </x-teacher.card.list>
      </x-teacher.card.card>
    </div>
  </x-teacher.container>
@endsection
