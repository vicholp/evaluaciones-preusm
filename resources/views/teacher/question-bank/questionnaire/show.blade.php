@extends('teacher.template.main')

@section('content')
  <x-teacher.container>
    <x-teacher.layout.title-bar
      :name="__('questionnaires')"
      :previus-route="route('teacher.question-bank.questionnaire-prototypes.index', ['where_subject_id' => request()->query('where_subject_id')])"
    >
      <x-slot:actions>
        <x-teacher.action-button
          :href="route('teacher.question-bank.questionnaire-prototypes.moodle-export', $questionnaire)"
          :body="__('moodle')"
        />
        <x-teacher.action-button
          :href="route('teacher.question-bank.questionnaire-prototypes.full', $questionnaire)"
          :body="__('print version')"
        />
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
      <x-base.card>
        <x-base.list :divide="false">
          <x-base.list.key-value :key="__('name')" :value="$questionnaire->latest->name"/>
          <x-base.list.key-value :key="__('subject')" :value="$questionnaire->subject->name"/>
          <x-base.list.key-value :key="__('description')" :value="$questionnaire->latest->description"/>
          <x-base.list.key-value :key="__('last modification')" :value="$questionnaire->latest->updated_at->diffForHumans()" />
          <x-base.list.separator />
          <x-base.list.key-value :key="__('questions')" :value="$questionnaire->latest->questions->count()" />
        </x-base.list>
      </x-base.card>
    </div>
    <div class="col-span-12">
      <x-teacher.card.table >
        <x-slot:header>
          <div class="col-span-1">
            N
          </div>
          <div class="col-span-7">
            Pregunta
          </div>
          <div class="col-span-4">

          </div>
        </x-slot:table>
        @foreach ($questionsSorted as $question)
          <x-teacher.card.table-row>
            <div class="col-span-1 flex items-center">
              <div class="font-bold"> {{ $question['index'] }} </div>
            </div>
            <div class="col-span-7 flex items-center">
              @if($question['item']->parent->name)
                <div> {{ $question['item']->parent->name }} </div>
              @else
                <questions-tiptap-mini :initial-content="`{{ $question['item']->body }}`" />
              @endif
            </div>
            <div class="col-span-4 flex flex-row gap-3 items-center justify-end">
              @if ($question['item']->parent->latest->id != $question['item']->id)
                <div class="rounded py-1 px-2 bg-black bg-opacity-5 dark:bg-white dark:bg-opacity-5 text-sm">
                  {{ __('desactualizado') }}
                </div>
              @endif
              <div class="text-sm italic">
                {{ $question['item']->reviewService()->getLastReviewer()?->name ?? '' }}
              </div>
              <x-teacher.action-button
                :href="route('teacher.question-bank.revision.question', [
                  $questionnaire->latest,
                  $question['item']
                ])"
                body="revisar"
                class="rounded px-2 py-1 bg-black bg-opacity-10"
              />
              <x-teacher.action-button
                :href="route('teacher.question-bank.question-prototypes.show', $question['item']->parent)"
                body="ver"
                class="rounded px-2 py-1 bg-black bg-opacity-10"
              />
            </div>
          </x-teacher.card.table-row>
        @endforeach
      </x-teacher.card.table>
    </div>
  </x-teacher.container>
@endsection
