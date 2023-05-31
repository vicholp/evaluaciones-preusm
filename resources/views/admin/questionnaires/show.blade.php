@extends('admin.template.main')

@section('content')
  <x-base.layout.container>
    <x-base.layout.title-bar
      :title="__('questionnaires')"
      :previus-route="route('admin.questionnaires.index')"
    >
      <x-slot:actions>
        <x-base.action
          :href="route('teacher.results.questionnaires.show', $questionnaire)"
          :body="__('results')"
        />
        <x-base.action
          :href="route('admin.results.upload', [
            'questionnaire_id' => $questionnaire
          ])"
          :body="__('upload results')"
        />
      </x-slot:actions>
    </x-base.layout.title-bar>
    <div class="col-span-12">
      <x-base.card>
        <x-base.list :divide="false">
          <x-base.list.key-value :key="__('name')" :value="$questionnaire->name"/>
          <x-base.list.key-value :key="__('subject')" :value="$questionnaire->subject->name"/>
          <x-base.list.separator />
          @if ($questionnaire->prototype)
            <x-base.list.key-value
              :key="__('prototype')"
              :value="$questionnaire->prototype->name"
              :link="route('teacher.question-bank.questionnaire-prototypes.show', $questionnaire->prototype->parent)"
            />
          @else
            <x-base.list.key-value
              :key="__('prototype')"
              value="sin prototipo"
            />
          @endif
          <x-base.list.separator />
          <x-base.list.key-value :key="__('questions')" :value="$questionnaire->questions->count()" />
        </x-base.list>
      </x-base.card>
    </div>
    <div class="col-span-12">
      <x-base.card padding="false">
        <x-base.table>
          <x-slot:header>
            <div class="col-span-1">
              Pregunta
            </div>
            <div class="col-span-1">
              Etiquetas
            </div>
            <div class="col-span-1">
              Correcta
            </div>
            <div class="col-span-1">
              Piloto
            </div>
          </x-slot:table>
          @foreach ($questionnaire->questions as $question)
            <x-base.table.row>
              <div class="col-span-1">
                <div class=""> {{ $question->position }} </div>
              </div>
              <div class="col-span-1">
                <div class="ml-2"> {{ $question->tags->count() }} </div>
              </div>
              <div class="col-span-1">
                <div class="ml-2"> {{ $question->alternatives()->whereCorrect(true)->first()?->name ?? 'n/a' }} </div>
              </div>
              <div class="col-span-1">
                <div class="ml-2"> {{ $question->pilot ? 'si' : 'no' }} </div>
              </div>
            </x-base.table.row>
          @endforeach
        </x-base.table>
      </x-base.card>
    </div>
  </x-base.layout.container>
  @endsection
