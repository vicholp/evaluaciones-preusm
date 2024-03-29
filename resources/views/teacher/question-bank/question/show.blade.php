@extends('teacher.template.main')

@section('content')
  <x-teacher.container>
    <x-teacher.layout.title-bar
      :name="__('questions')"
      :previus-route="route('teacher.question-bank.question-prototypes.index', [
          'where_subject_id' => request()->query('where_subject_id'),
      ])"
    >
      <x-slot:actions>
        <x-base.action
          method="POST"
          type="form"
          :href="route('teacher.question-bank.question-prototypes.review', $question)"
          :body="__($reviewService->getReviewButtonName($user))"
          :icon="$reviewService->canBeReviewedBy($user) ? 'mdi:check' : 'mdi:close'"
        />
        <x-base.action
          :href="route('teacher.question-bank.question-prototypes.edit', [
              $question,
              'where_subject_id' => request()->query('where_subject_id'),
          ])"
          :body="__('edit')"
          icon="mdi:pencil"
        />
      </x-slot:actions>
    </x-teacher.layout.title-bar>
    <div class="col-span-12">
      <x-base.card>
        <x-base.list :divide="false">
          <x-base.list.key-value
            :key="__('subject')"
            :value="$question->subject->name"
          />
          @if ($question->statement)
            <x-base.list.key-value
              :key="__('statement')"
              :value="$question->statement?->name"
              :link="route('teacher.question-bank.statement-prototypes.show', $question->statement)"
            />
          @endif
          <x-base.list.key-value
            :key="__('name')"
            :value="$question->latest->name"
          />
          <x-base.list.key-value
            :key="__('description')"
            :value="$question->latest->description"
          />
          <x-base.list.key-value :key="__('tags')">
            <x-slot:value>
              <div class="flex flex-wrap gap-2">
                @forelse ($question->latest->tags as $tag)
                  <div class="rounded bg-black bg-opacity-5 py-1 px-2 text-sm dark:bg-white dark:bg-opacity-5">
                    {{ __($tag->tagGroup->name) }}: {{ $tag->name }}
                  </div>
                @empty
                  <div class="rounded bg-black bg-opacity-5 py-1 px-2 text-sm dark:bg-white dark:bg-opacity-5">
                    <i>
                      {{ __('without tags') }}
                    </i>
                  </div>
                @endforelse
              </div>
            </x-slot:value>
          </x-base.list.key-value>
          <x-base.list.key-value
            :key="__('version')"
            :value="$question->latest->index"
          />
          <x-base.list.key-value
            :key="__('last reviewer')"
            :value="$reviewService->getLastReviewer()?->name ?? __('no reviewers')"
          />
        </x-base.list>
      </x-base.card>
    </div>
    <div class="col-span-12">
      <x-base.card :header="__('content')">
        <div class="flex justify-center">
          <questions-tiptap
            :version-id="{{ $question->latest->id }}"
            :editable="false"
          >
          </questions-tiptap>
        </div>
      </x-base.card>
    </div>
    <div class="col-span-12">
      <x-base.card :header="__('solution')">
        <div class="flex justify-center">
          <teacher-question-bank-questions-tiptap
            :initial-content="`{{ Str::replace('\\', '\\\\', $question->latest->solution) ?? __('<i>without solution</i>') }}`"
            :editable="false"
          >
          </teacher-question-bank-questions-tiptap>
        </div>
        <div class="mt-3"></div>
        <x-base.list :divide="false">
          <x-base.list.key-value
            :key="__('answer')"
            :value="$question->latest->answer"
          />
        </x-base.list>
      </x-base.card>
    </div>
    </div>
  </x-teacher.container>
@endsection
