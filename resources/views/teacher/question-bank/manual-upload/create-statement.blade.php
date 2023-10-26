@extends('teacher.template.main')

@section('content')
  <x-base.layout.container>
    <x-teacher.layout.title-bar :name="__('manual upload') . ' - ' . $latest->questions()->count() + 1">
      <x-slot:actions>
        <x-base.action
          type="submit"
          form="form-start"
        >
          Subir
        </x-base.action>
        <x-base.action :href="route('teacher.question-bank.manual-upload.review', $questionnairePrototype)">
          Terminar
        </x-base.action>
      </x-slot:actions>
    </x-teacher.layout.title-bar>
    <div class="col-span-12">
      <x-base.form
        :action="route('teacher.question-bank.manual-upload.store-statement', $questionnairePrototype)"
        method="POST"
        id="form-start"
      >
        <div class="grid grid-cols-12 gap-4">
          <div class="col-span-6">
            <x-base.card :header="__('information')">
              <x-base.form.list>
                <x-base.list.item>
                  <div class="flex w-full flex-col gap-1">
                    <label class="font-medium">
                      {{ __('body') }}
                    </label>
                    <v-tiptap
                      name="body"
                      :text-tools="true"
                    >
                    </v-tiptap>
                  </div>
                </x-base.list.item>

              </x-base.form.list>
            </x-base.card>
          </div>
          <div class="col-span-6">
            <x-base.card :header="__('optional')">
              <x-base.form.list>
                <x-base.list.item>
                  <div class="flex w-full flex-col gap-1">
                    <label class="font-medium">
                      {{ __('name') }}
                    </label>
                    <x-base.form.input-text attribute="name" />
                  </div>
                </x-base.list.item>
                <x-base.list.item>
                  <div class="flex w-full flex-col gap-1">
                    <label class="font-medium">
                      {{ __('description') }}
                    </label>
                    <x-base.form.input-text attribute="description" />
                  </div>
                </x-base.list.item>
              </x-base.form.list>
            </x-base.card>
          </div>
        </div>
      </x-base.form>
    </div>
    <div class="col-span-6"></div>
    <div class="col-span-12">
      <x-base.card :header="__('questions')">
        <x-utils.card.list>
          @foreach ($itemsSorted as $index => $item)
            @if ($item['type'] === 'question')
              <a
                class="ml-3"
                href="{{ route('teacher.question-bank.question-prototypes.show', $item['item']->parent) }}"
              >
                <x-base.list.item>
                  asdasd --
                  {{ $item['index'] }} - {{ $item['item']->name }}
                </x-base.list.item>
              </a>
            @elseif ($item['type'] === 'statement')
              <a href="{{ route('teacher.question-bank.statement-prototypes.show', $item['item']) }}">
                <x-base.list.item>
                  {{ __('statement') }} {{ $item['item']->pivot->statement_position }} -
                  {{ $item['item']->name }}
                </x-base.list.item>
              </a>
            @endif
          @endforeach
        </x-utils.card.list>
      </x-base.card>
    </div>
  </x-base.layout.container>
@endsection
