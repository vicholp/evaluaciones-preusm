@extends('teacher.template.main')

@section('content')
  <x-base.layout.container>
    <x-teacher.layout.title-bar
      :name="__('manual upload')"
      :previus-route="route('teacher.question-bank.questionnaire-prototypes.index', [
          'where_subject_id' => request()->query('where_subject_id'),
      ])"
    >
      <x-slot:actions>
        <x-base.action :href="route('teacher.question-bank.questionnaire-prototypes.index', [
            'where_subject_id' => request()->query('where_subject_id'),
        ])">
          Cancelar
        </x-base.action>
      </x-slot:actions>
    </x-teacher.layout.title-bar>
    <div class="col-span-6 flex flex-col gap-3">
      <x-base.card>
        <p>
          Al iniciar el proceso, podras subir una a una las preguntas del ensayo, en
          el mismo orden en que aparecen.
        </p>
      </x-base.card>
      <x-base.card>
        <p>
          Al iniciar el proceso, podras subir una a una las preguntas del ensayo, en
          el mismo orden en que aparecen.
        </p>
      </x-base.card>
    </div>
    <div class="col-span-6">
      <x-base.card :header="__('information')">
        <x-base.form
          :action="route('teacher.question-bank.manual-upload.store-questionnaire')"
          method="POST"
          id="form-start"
        >
          <x-base.form.list>
            <x-base.form.list.item
              input="select"
              :attribute="__('subject')"
              name="subject_id"
              :options="$subjects"
              :value="request()->query('where_subject_id')"
            />
            <x-base.form.list.item
              input="text"
              :attribute="__('name')"
              name="name"
              :value="__('manual upload') . ' ' . today()->format('Y-m-d')"
            />
            <x-base.form.list.item
              input="text"
              :attribute="__('description')"
              name="description"
              :value="__('manual upload') . ' ' . today()->format('Y-m-d')"
            />
          </x-base.form.list>
          <x-base.action
            type="submit"
            form="form-start"
            class="mt-3"
          >
            Iniciar
          </x-base.action>
        </x-base.form>
      </x-base.card>
      </a>
    </div>
  </x-base.layout.container>
@endsection
