@extends('teacher.template.main')

@section('content')
  <x-base.layout.container>
    <x-base.layout.title-bar
      :title="__('questionnaires')"
      :previus-route="route('teacher.question-bank.questionnaire-prototypes.index', [
          'where_subject_id' => request()->query('where_subject_id'),
      ])"
    >
      <x-slot:actions>
        <v-dropdown title="{{ __('export') }}">
          <v-dropdown-item
            href="{{ route('teacher.question-bank.questionnaire-prototypes.export-moodle', $questionnaire) }}"
            body="{{ __('export to moodle') }}"
          ></v-dropdown-item>
          <v-dropdown-item
            href="{{ route('teacher.question-bank.questionnaire-prototypes.export-pdf', $questionnaire) }}"
            body="{{ __('export to pdf') }}"
          ></v-dropdown-item>
          <v-dropdown-item
            href="{{ route('teacher.question-bank.questionnaire-prototypes.export-sheet-xlsx', $questionnaire->latest) }}"
            body="{{ __('export sheet to xslx') }}"
          ></v-dropdown-item>
        </v-dropdown>
        <x-base.action
          :href="route('teacher.question-bank.revision.questionnaire', $questionnaire->latest)"
          :body="__('revision') . ' ' . __('questionnaire')"
        />
        <x-base.action
          :href="route('teacher.question-bank.questionnaire-prototypes.edit', $questionnaire)"
          :body="__('edit') . ' ' . __('questionnaire')"
        />
        <x-base.action
          :href="route('teacher.question-bank.questionnaire-prototypes.edit-questions', $questionnaire)"
          :body="__('edit') . ' ' . __('questions')"
        />
      </x-slot:actions>
    </x-base.layout.title-bar>
    <div class="col-span-12">
      <x-base.card>
        <x-base.list :divide="false">
          <x-base.list.key-value
            :key="__('name')"
            :value="$questionnaire->latest->name"
          />
          <x-base.list.key-value
            :key="__('subject')"
            :value="$questionnaire->subject->name"
          />
          <x-base.list.key-value
            :key="__('description')"
            :value="$questionnaire->latest->description"
          />
          <x-base.list.key-value
            :key="__('last modification')"
            :value="$questionnaire->latest->updated_at->diffForHumans()"
          />
          <x-base.list.separator />
          <x-base.list.key-value
            :key="__('questions')"
            :value="$questionnaire->latest->questions->count()"
          />
        </x-base.list>
      </x-base.card>
    </div>
    <div class="col-span-12">
      <x-base.card padding="false">
        <x-base.table>
          <x-slot:header>
            <div class="col-span-1">
            </div>
            <div class="col-span-7">
            </div>
            <div class="col-span-4">
            </div>
            </x-slot:table>
            @foreach ($questionsSorted as $question)
              <x-base.table.row>
                <div class="col-span-1 flex items-center">
                  <div class="font-bold"> {{ $question['index'] }} </div>
                </div>
                <div class="col-span-7 flex items-center">
                  @if ($question['item']->parent->name)
                    <div> {{ $question['item']->parent->name }} </div>
                  @else
                    <questions-tiptap-mini :version-id="{{ $question['item']->id }}">
                    </questions-tiptap-mini>
                  @endif
                </div>
                <div class="col-span-4 flex flex-row items-center justify-end gap-3">
                  @if ($question['item']->parent->latest->id != $question['item']->id)
                    <div class="rounded bg-black bg-opacity-5 py-1 px-2 text-sm dark:bg-white dark:bg-opacity-5">
                      {{ __('desactualizado') }}
                    </div>
                    <x-base.action
                      body="actualizar"
                      padding="px-2 py-1"
                      :href="route(
                          'teacher.question-bank.questionnaire-prototypes.update-question-to-latest-version',
                          [$questionnaire, 'question_prototype_id' => $question['item']->parent],
                      )"
                    />
                  @endif
                  <div class="text-sm italic">
                    {{ $question['item']->reviewService()->getLastReviewer()?->name ?? '' }}
                  </div>
                  <x-base.action
                    :href="route('teacher.question-bank.revision.question', [
                        $questionnaire->latest,
                        $question['item'],
                    ])"
                    body="revisar"
                    class="rounded bg-black bg-opacity-10 px-2 py-1"
                  />
                  <x-base.action
                    :href="route('teacher.question-bank.question-prototypes.show', $question['item']->parent)"
                    body="ver"
                    class="rounded bg-black bg-opacity-10 px-2 py-1"
                  />
                </div>
              </x-base.table.row>
            @endforeach
        </x-base.table>
      </x-base.card>
    </div>
  </x-base.layout.container>
@endsection
