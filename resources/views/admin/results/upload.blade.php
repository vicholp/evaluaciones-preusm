@extends('admin.template.main')

@section('content')
  <x-base.layout.container>
    <x-base.layout.title-bar
      :title="__('upload results')"
      :previus-route="route('admin.questionnaires.index')"
    >
      <x-slot:actions>
        <x-base.action
          type="submit"
          form="form"
          :body="__('results')"
        />
      </x-slot:actions>
    </x-base.layout.title-bar>
    <div class="col-span-12 flex flex-col gap-3">
      @if ($errors->any())
        <div class="col-span-12 rounded bg-red-200 p-3">
          <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif
      <x-base.card>
        <x-base.form
          :action="route('admin.results.import')"
          :method="'POST'"
          :file="true"
          :idForm="'form-questionaire'"
          enctype="multipart/form-data"
        >
          <x-base.form.list>
            <x-base.form.list.item
              input="select-model"
              :attribute="__('questionnaire')"
              name="questionnaire_id"
              :options="$questionnaires"
              :value="request()->query('questionnaire_id')"
              required
            />
            <x-base.form.list.item
              input="file"
              :attribute="__('file of answers from aula')"
              name="file_answers"
              accept=".xlsx"
            />
            <x-base.form.list.item
              input="file"
              :attribute="__('file of answers from formscanner')"
              name="file_formscanner"
              accept=".csv"
            />
            <x-base.form.list.item
              input="file"
              :attribute="__('file of tags')"
              name="file_tags"
              accept=".xlsx"
            />

            <x-base.form.list.item
              input="file"
              :attribute="__('file grades')"
              name="file_grades"
              class="mt-10"
            />
          </x-base.form.list>
        </x-base.form>

      </x-base.card>
    </div>
  </x-base.layout.container>
@endsection
