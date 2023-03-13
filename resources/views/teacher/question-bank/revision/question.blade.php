@extends('teacher.template.main')

@section('content')
  <x-teacher.container>
    <x-teacher.layout.title-bar
      :name="__('checking question') . ' ' . $position . '/' . $totalQuestions"
    >
      <x-slot:actions>
        <x-teacher.action-button
        form="question-form" type="submit" :body="__('update')"
        />
        <div class="px-2">
        </div>
        @if ($previusQuestion)
          <x-teacher.action-button
            :href="route('teacher.question-bank.revision.question', [
              $questionnaire,
              $previusQuestion
            ])"
            :body="__('previous question')"
            color="bg-indigo-500"
          />
        @endif
        @if ($nextQuestion)
          <x-teacher.action-button
            :href="route('teacher.question-bank.revision.question', [
              $questionnaire,
              $nextQuestion
            ])"
            :body="__('next question')"
          />
        @else
          <x-teacher.action-button
            :href="route('teacher.question-bank.questionnaire-prototypes.show', [
              $questionnaire->parent,
            ])"
            :body="__('finish revision')"
          />
        @endif
      </x-slot:actions>
    </x-teacher.layout.title-bar>
    <div class="col-span-12">
      <x-teacher.forms.form
        method="PUT"
        :action="route('teacher.question-bank.revision.update-question', [
          $questionnaire, $question
        ])"
        id="question-form"
      >
        <x-teacher.card.card :header="__('information')">
          <div class="flex flex-col gap-3">
            <x-teacher.forms.input-text :attribute="__('subject')" :value="$question->parent->subject->name" disabled/>
            <x-teacher.forms.input-text :attribute="__('name')" name="name" :value="$question->name"/>
            <x-teacher.forms.input-text :attribute="__('description')" name="description" :value="$question->description"/>
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
            <x-teacher.forms.input-select :attribute="__('answer')" name="answer" :value="$question->answer" :options="['A', 'B', 'C', 'D', 'E']"/>
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
            @foreach($tags as $tag)
              <x-teacher.forms.input :attribute="__($tag->name)">
                <div class="col-span-8">
                  <teacher-question-bank-quesitons-multiselect-tags name="tags[]" :options='@json($tag->tags)' :value='@json($selectedTags[$tag->name])'>
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
