@extends('teacher.template.main')

@section('content')
  <x-teacher.container>
    <x-teacher.layout.title-bar
      :name="__('questionnaires')"
      :previus-route="route('teacher.question-bank.questionnaire-prototypes.show', [$questionnaire, 'where_subject_id' => request()->query('where_subject_id')])"
    >
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
          @foreach ($questionsSorted as $question)
            <x-teacher.card.list-item>
              <div class="flex flex-row gap-2 items-center justify-center w-full">
                <div class="flex justify-center">
                  <teacher-question-bank-questions-tiptap
                    :initial-content="`{{ Str::replace('\\', '\\\\', $question['item']->body) }}`"
                    :editable="false"
                  >
                  </teacher-question-bank-questions-tiptap>
                </div>
              </div>
            </x-teacher.card.list-item>
          @endforeach
        </x-teacher.card.list>
      </x-teacher.card.card>
    </div>
  </x-teacher.container>
@endsection
