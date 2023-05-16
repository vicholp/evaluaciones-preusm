@extends('teacher.template.main')

@section('content')
  <x-teacher.container>
    <x-teacher.layout.title-bar :name="__('question')">
      <x-slot:actions>
        <x-teacher.action-button form="question-form" type="submit" :body="__('submit')" />
      </x-slot:actions>
    </x-teacher.layout.title-bar>
    <div class="col-span-12">
      <x-teacher.forms.form method="POST" :action="route('teacher.question-bank.questionnaire-prototypes.compilation.store')" id="question-form">
        <x-base.card :header="__('information')">
          <x-base.form.list>
            <x-base.form.list.item input="select-model" :attribute="__('subject')" name="subject_id" :options="$subjects" :value="request()->query('where_subject_id')"/>
            <x-base.form.list.item input="text" :attribute="__('name')" name="name"/>
            <x-base.form.list.item input="text" :attribute="__('description')" name="description"/>
          </x-base.form.list>
        </x-base.card>
        <x-base.card :header="__('compilar')">
          <x-base.form.list>
            <div class="grid grid-cols-12 items-center py-3">
              <div class="col-span-4">Ensayo base 1</div>
              <div class="col-span-8">
                <select @class("rounded h-10 px-2 w-full
                  focus:border-blue-500 focus:border-2 focus:ring-0
                  disabled:text-opacity-60 disabled:text-white
                  border-black border-opacity-20 border-1
                  dark:border-white dark:border-opacity-10 dark:border-1
                  bg-dark bg-opacity-10
                  dark:bg-black dark:bg-opacity-30")
                  name="questionnaire_prototype_id[]"
                >
                  <option value="" >Ninguno</option>
                  @foreach ($questionnairePrototypes as $questionnairePrototype)
                    <option value="{{ $questionnairePrototype->id }}" class="dark:bg-gray-900" >
                      {{ $questionnairePrototype->subject->name }} - {{ Str::ucfirst($questionnairePrototype->name) }}
                    </option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="grid grid-cols-12 items-center py-3">
              <div class="col-span-4">Ensayo base 1</div>
              <div class="col-span-8">
                <select @class("rounded h-10 px-2 w-full
                  focus:border-blue-500 focus:border-2 focus:ring-0
                  disabled:text-opacity-60 disabled:text-white
                  border-black border-opacity-20 border-1
                  dark:border-white dark:border-opacity-10 dark:border-1
                  bg-dark bg-opacity-10
                  dark:bg-black dark:bg-opacity-30")
                  name="questionnaire_prototype_id[]"
                >
                  <option value="" >Ninguno</option>
                  @foreach ($questionnairePrototypes as $questionnairePrototype)
                    <option value="{{ $questionnairePrototype->id }}" class="dark:bg-gray-900" >
                      {{ $questionnairePrototype->subject->name }} - {{ Str::ucfirst($questionnairePrototype->name) }}
                    </option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="grid grid-cols-12 items-center py-3">
              <div class="col-span-4">Ensayo base 1</div>
              <div class="col-span-8">
                <select @class("rounded h-10 px-2 w-full
                  focus:border-blue-500 focus:border-2 focus:ring-0
                  disabled:text-opacity-60 disabled:text-white
                  border-black border-opacity-20 border-1
                  dark:border-white dark:border-opacity-10 dark:border-1
                  bg-dark bg-opacity-10
                  dark:bg-black dark:bg-opacity-30")
                  name="questionnaire_prototype_id[]"
                >
                  <option value="" >Ninguno</option>
                  @foreach ($questionnairePrototypes as $questionnairePrototype)
                    <option value="{{ $questionnairePrototype->id }}" class="dark:bg-gray-900" >
                      {{ $questionnairePrototype->subject->name }} - {{ Str::ucfirst($questionnairePrototype->name) }}
                    </option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="grid grid-cols-12 items-center py-3">
              <div class="col-span-4">Ensayo base 1</div>
              <div class="col-span-8">
                <select @class("rounded h-10 px-2 w-full
                  focus:border-blue-500 focus:border-2 focus:ring-0
                  disabled:text-opacity-60 disabled:text-white
                  border-black border-opacity-20 border-1
                  dark:border-white dark:border-opacity-10 dark:border-1
                  bg-dark bg-opacity-10
                  dark:bg-black dark:bg-opacity-30")
                  name="questionnaire_prototype_id[]"
                >
                  <option value="" >Ninguno</option>
                  @foreach ($questionnairePrototypes as $questionnairePrototype)
                    <option value="{{ $questionnairePrototype->id }}" class="dark:bg-gray-900" >
                      {{ $questionnairePrototype->subject->name }} - {{ Str::ucfirst($questionnairePrototype->name ?? 'Sin nombre') }}
                    </option>
                  @endforeach
                </select>
              </div>
            </div>
          </x-base.form.list>
        </x-base.card>
      </x-teacher.forms.form>
    </div>
  </x-teacher.container>
@endsection
