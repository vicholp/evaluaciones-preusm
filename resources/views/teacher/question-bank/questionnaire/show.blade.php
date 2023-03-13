@extends('teacher.template.main')

@section('content')
  <x-teacher.container>
    <x-teacher.layout.title-bar
      :name="__('questionnaires')"
      :previus-route="route('teacher.question-bank.questionnaire-prototypes.index', ['where_subject_id' => request()->query('where_subject_id')])"
    >
      <x-slot:actions>
        <x-teacher.action-button
          :href="route('teacher.question-bank.revision.questionnaire', $questionnaire->latest)"
          :body="__('revision') . ' ' . __('questionnaire')"
        />
        <x-teacher.action-button
          :href="route('teacher.question-bank.questionnaire-prototypes.edit', $questionnaire)"
          :body="__('edit') . ' ' . __('questionnaire')"
        />
        <x-teacher.action-button
          :href="route('teacher.question-bank.questionnaire-prototypes.edit-questions', $questionnaire)"
          :body="__('edit') . ' ' . __('questions')"
        />
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
          @foreach ($questionsSorted as $question)
            <x-teacher.card.list-item>
              <div class="flex flex-row gap-2 items-center w-full">
                <div>
                  <a href="{{ route('teacher.question-bank.question-prototypes.show', $question['item']->parent) }}" >
                    <span> {{ $question['index'] }} - </span>
                    @if($question['item']->parent->name)
                      <span> {{ $question['item']->parent->name }} </span>
                    @else
                      <questions-tiptap-mini :initial-content="`{{ $question['item']->body }}`" />
                    @endif
                  </a>
                </div>
                <div class="ml-auto">
                  <x-teacher.action-button
                    :href="route('teacher.question-bank.revision.question', [
                      $questionnaire->latest,
                      $question['item']
                    ])"
                    body="revisar desde aqui"
                    class="rounded px-2 py-1 bg-black bg-opacity-5 ml-auto"
                  />
                </div>
              </div>
            </x-teacher.card.list-item>
          @endforeach
        </x-teacher.card.list>
      </x-teacher.card.card>
    </div>
  </x-teacher.container>
@endsection
