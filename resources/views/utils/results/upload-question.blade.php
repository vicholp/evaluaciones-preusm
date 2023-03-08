@extends('utils.template.main')

@section('content')
  <x-utils.container>
    <div class="col-span-12">
      <x-utils.card.card>
          <x-utils.forms.form :action="route('utils.results.store-question', $questionnaire)" method="POST" id="form-start">
            <div class="flex items-center">
              <teacher-question-bank-questions-tiptap
                name="body"
              />
            </div>
            <x-utils.action-button type="submit" form="form-start">
              Crear
            </x-utils.action-button>
          </x-utils.forms.form>
        </x-utils.card.card>
      </a>
    </div>
  </x-utils.container>
@endsection
