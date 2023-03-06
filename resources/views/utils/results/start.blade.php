@extends('utils.template.main')

@section('content')
  <x-utils.container>
    <div class="col-span-12">
      <x-utils.card.card>
          <x-utils.forms.form :action="route('utils.results.store-questionnaire')" method="POST" id="form-start">
            <x-utils.forms.input-select
              :attribute="__('questionnaire group')"
              name="questionnaire_group_id"
              :options="$questionnaireGroups"
            />
            <x-utils.forms.input-select
              :attribute="__('subject')"
              name="subject_id"
              :options="$subjects"
            />
          </x-utils.forms.form>
        </x-utils.card.card>
      </a>
    </div>
  </x-utils.container>
@endsection
