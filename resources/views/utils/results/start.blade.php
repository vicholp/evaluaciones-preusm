@extends('utils.template.main')

@section('content')
  <x-utils.container>
    <div class="col-span-12">
      <x-utils.card.card>
          <x-utils.forms :action="route('utils.results')" method="POST">
            <x-utils.input-select :name="__('questionnaire group')" />
          </x-utils.forms
        </x-utils.card.card>
      </a>
    </div>
  </x-utils.container>
@endsection
