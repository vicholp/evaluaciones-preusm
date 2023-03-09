@extends('utils.template.main')

@section('content')
  <x-utils.container>
    <div class="col-span-12">
      <x-utils.card.card :header="__('question') . ' ' . $position">
          <x-utils.forms.form :action="route('utils.results.store-question', $questionnaire)" method="POST" id="form-start">
            <div class="flex justify-center">
              <teacher-question-bank-questions-tiptap
                name="body"
              />
            </div>
            <x-utils.forms.input-select attribute="answer" :options="['A', 'B', 'C', 'D', 'E']" />
            <x-utils.action-button type="submit" form="form-start">
              Crear
            </x-utils.action-button>
          </x-utils.forms.form>
        </x-utils.card.card>
    </div>
      <div class="col-span-12">
        <x-utils.card.card :header="__('questions')">
          <x-utils.card.list>
            @foreach ($questionnaire->prototype->questions as $question)
              <x-utils.card.list-item>
                {{ $question->id }}
              </x-utils.card.list-item>
              @endforeach
          </x-utils.card.list>
        </x-utils.card.card>
      </div>
    </div>
  </x-utils.container>
@endsection
