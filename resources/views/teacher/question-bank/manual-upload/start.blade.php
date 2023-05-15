@extends('teacher.template.main')

@section('content')
  <x-base.layout.container>
    <x-teacher.layout.title-bar
      :name="__('questionnaires')"
      :previus-route="route('teacher.question-bank.questionnaire-prototypes.index', ['where_subject_id' => request()->query('where_subject_id')])"
    >
      <x-slot:actions>
        <x-base.action type="submit" form="form-start">
          Iniciar
        </x-base.action>
      </x-slot:actions>
    </x-teacher.layout.title-bar>
    <div class="col-span-12">
      <x-base.card>
          <x-base.form :action="route('teacher.question-bank.manual-upload.store-questionnaire')" method="POST" id="form-start">
            <x-base.form.list>
              <x-base.form.list.item
              input="select"
              :attribute="__('subject')"
              name="subject_id"
              :options="$subjects"
              :value="request()->query('where_subject_id')"
            />
            </x-base.form.list>
          </x-base.form>
        </x-base.card>
      </a>
    </div>
  </x-base.layout.container>
@endsection
