@extends('admin.template.main')

@section('content')
  <x-base.layout.container>
    <x-base.layout.title-bar
      :title="__('questionnaires')"
      :previus-route="route('admin.questionnaires.index')"
    >
      <x-slot:actions>
        <x-base.action
          type="form"
          method="DELETE"
          :href="route('admin.questionnaires.destroy', $questionnaire)"
          :body="__('delete')"
          icon="mdi-delete"
          color="bg-danger"
          dark-color="bg-danger"
        />
        <x-base.action
          form="question-form"
          type="submit"
          :body="__('save')"
          icon="mdi-content-save"
        />
      </x-slot:actions>
    </x-base.layout.title-bar>
    <div class="col-span-12">
      <x-base.form.errors />
    </div>
    <div class="col-span-12">
      <x-base.card>
        <x-base.form
          :action="route('admin.questionnaires.update', $questionnaire)"
          id="question-form"
          method="PUT"
        >
          <x-base.form.list>
            <x-base.form.list.item
              attribute="name"
              :value="$questionnaire->name"
              :label="__('name')"
            />
          </x-base.form.list>
        </x-base.form>
      </x-base.card>
    </div>
  </x-base.layout.container>
@endsection
