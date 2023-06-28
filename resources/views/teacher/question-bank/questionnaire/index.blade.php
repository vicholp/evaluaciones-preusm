@extends('teacher.template.main')

@section('content')
  <x-teacher.container>
    <x-teacher.layout.title-bar
      :name="__('question bank') . ' - ' . __('questionnaires')"
      :previus-route="route('teacher.question-bank.index')"
    >
      <x-slot:actions>
        <v-dropdown title="opciones">
          <v-dropdown-item
            href="{{ route('teacher.question-bank.questionnaire-prototypes.compilation.create', [
                'where_subject_id' => request()->query('where_subject_id'),
            ]) }}"
            body="{{ __('crear compilacion') }}"
          >
          </v-dropdown-item>
          <v-dropdown-item
            href="{{ route('teacher.question-bank.manual-upload.start', [
                'where_subject_id' => request()->query('where_subject_id'),
            ]) }}"
            body="{{ __('manual upload') }}"
          >
          </v-dropdown-item>
        </v-dropdown>
        <x-base.action
          :href="route('teacher.question-bank.questionnaire-prototypes.create', [
              'where_subject_id' => request()->query('where_subject_id'),
          ])"
          :body="__('create :name', ['name' => __('questionnaire')])"
          icon="mdi-plus"
        />
      </x-slot:actions>
    </x-teacher.layout.title-bar>
    <div class="col-span-12">
      <x-base.card padding="false">
        <x-base.table>
          <x-slot:header>
            {{ __('questionnaires') }}
          </x-slot:header>
          @foreach ($questionnaires as $questionnaire)
            <a href="{{ route('teacher.question-bank.questionnaire-prototypes.show', [$questionnaire]) }} ">
              <x-base.table.row>
                <div class="col-span-4">
                  {{ $questionnaire->latest->name ?? 'sin nombre' }}
                </div>
                <div class="col-span-6">
                  {{ $questionnaire->latest->description ?? 'sin descripcion' }}
                </div>
                <div class="col-span-2">
                  {{ $questionnaire->latest->questions->count() }} {{ __('questions') }}
                </div>
              </x-base.table.row>
            </a>
          @endforeach
        </x-base.table>
      </x-base.card>
    </div>
  </x-teacher.container>
@endsection
