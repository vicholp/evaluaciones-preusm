@extends('teacher.template.main')

@section('content')
  <x-teacher.container>
    <x-teacher.layout.title-bar :name="__('checking question') . ' ' . $position . '/' . $totalQuestions">
      <x-slot:actions>

        <x-base.action
          :href="route('teacher.question-bank.questionnaire-prototypes.show', $questionnaire->parent)"
          :body="__('return to questionnaire')"
        />
        <div class="px-2">
        </div>
        <x-base.action
          form="question-form"
          type="submit"
          :body="__('save')"
          icon="mdi-content-save"
        />
        <div class="px-2">
        </div>
        <x-base.action
          method="POST"
          type="form"
          :href="route('teacher.question-bank.revision.review', [$questionnaire, $question])"
          :body="__($reviewService->getReviewButtonName($user))"
          :icon="$reviewService->canBeReviewedBy($user) ? 'mdi:check' : 'mdi:close'"
        />
        <div class="px-2">
        </div>
        @if ($previusQuestion)
          <x-base.action
            :href="route('teacher.question-bank.revision.question', [$questionnaire, $previusQuestion])"
            icon="mdi-arrow-left"
            :body="$position - 1"
          />
        @endif
        @if ($nextQuestion)
          <x-base.action
            :href="route('teacher.question-bank.revision.question', [$questionnaire, $nextQuestion])"
            icon="mdi-arrow-right"
            :body="$position + 1"
          />
        @else
          <x-base.action
            :href="route('teacher.question-bank.questionnaire-prototypes.show', [$questionnaire->parent])"
            :body="__('finish revision')"
          />
        @endif
      </x-slot:actions>
    </x-teacher.layout.title-bar>
    <div class="col-span-12">
      <x-teacher.card.card :header="__('question')">
        <x-teacher.card.list :divide="false">
          <x-teacher.card.list-key-value
            :key="__('last reviewer')"
            :value="$reviewService->getLastReviewer()?->name ?? __('no reviewers')"
          />
        </x-teacher.card.list>
      </x-teacher.card.card>
    </div>
    <div class="col-span-12">
      <x-teacher.forms.form
        method="PUT"
        :action="route('teacher.question-bank.revision.update-question', [$questionnaire, $question])"
        id="question-form"
      >
        <x-teacher.card.card :header="__('information')">
          <div class="flex flex-col gap-3">
            <x-teacher.forms.input-text
              :attribute="__('name')"
              name="name"
              :value="$question->name"
            />
            <x-teacher.forms.input-text
              :attribute="__('description')"
              name="description"
              :value="$question->description"
            />
          </div>
        </x-teacher.card.card>
        <x-teacher.card.card :header="__('content')">
          <div class="flex flex-col gap-3">
            <teacher-question-bank-questions-tiptap
              :initial-content="`{{ Str::replace('\\', '\\\\', $question->body) }}`"
              name="body"
              class="mx-auto"
            >
            </teacher-question-bank-questions-tiptap>
          </div>
        </x-teacher.card.card>
        <x-teacher.card.card :header="__('solution')">
          <div class="flex flex-col gap-3">
            <x-teacher.forms.input-select
              :attribute="__('answer')"
              name="answer"
              :value="$question->answer"
              :options="['A', 'B', 'C', 'D', 'E']"
            />
            <teacher-question-bank-questions-tiptap
              :initial-content="`{{ Str::replace('\\', '\\\\', $question->solution) }}`"
              name="solution"
              class="mx-auto"
            >
            </teacher-question-bank-questions-tiptap>
          </div>
        </x-teacher.card.card>
        <x-teacher.card.card :header="__('tags')">
          <div class="flex flex-col gap-3">
            @foreach ($tagGroups as $tagGroup)
              <x-teacher.forms.input :attribute="__($tagGroup->name)">
                <div class="col-span-8">
                  <teacher-question-bank-quesitons-multiselect-tags
                    name="tags[]"
                    :options='@json($tags[$tagGroup->id])'
                    :value='@json($selectedTags[$tagGroup->name])'
                  >
                  </teacher-question-bank-quesitons-multiselect-tags>
                </div>
              </x-teacher.forms.input>
            @endforeach
          </div>
        </x-teacher.card.card>
      </x-teacher.forms.form>
    </div>
  </x-teacher.container>
@endsection
