@extends('utils.template.main')

@section('content')
  <x-utils.container>
    <div class="col-span-12 ">
      <x-utils.card.card>
        <a href="{{ route('utils.questionnaire-groups.show', $questionnaireGroup) }}">
          {{ $questionnaireGroup->name }}
        </a>
        <x-slot:footer>
          <a href="{{ route('utils.questionnaire-groups.index') }}">
            {{ __('see all questionnaires') }}
          </a>
        </x-slot:footer>
      </x-utils.card.card>
    </div>
    <div class="col-span-12">
      <a href="{{ route('utils.question-bank.index') }}">
        <x-utils.card.card>
          {{ __('question bank') }}
        </x-utils.card.card>
      </a>
    </div>
  </x-utils.container>
@endsection
