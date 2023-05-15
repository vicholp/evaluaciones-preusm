@extends('teacher.template.main')

@section('content')
  <x-base.layout.container>
    <x-teacher.layout.title-bar
      :name="__('manual upload') . ' - ' . $latest->questions()->count() + 1"
    >
      <x-slot:actions>
        <x-base.action type="submit" form="form-start">
          Subir
        </x-base.action>
        <x-base.action :href="route('teacher.question-bank.manual-upload.review', $questionnairePrototype)">
          Terminar
        </x-base.action>
      </x-slot:actions>
    </x-teacher.layout.title-bar>
    <div class="col-span-12">
      <x-base.card :header="__('question')">
        <x-base.form :action="route('teacher.question-bank.manual-upload.store-question', $questionnairePrototype)"
          method="POST" id="form-start">
          <x-base.form.list>
            <div class="grid grid-cols-12 items-center py-4">
              <div class="col-span-4">
                Contenido
              </div>
              <div class="col-span-8 flex flex-row justify-center">
                <teacher-question-bank-questions-tiptap
                  name="body"
                />
              </div>
            </div>
          </x-base.form.list>
          <x-utils.forms.input-select attribute="answer" :options="['A', 'B', 'C', 'D', 'E']" />
        </x-base.form>
      </x-base.card>
    </div>
    <div class="col-span-12">
      <x-base.card :header="__('questions')">
        <x-utils.card.list>
          @foreach ($latest->questions as $question)
            <x-utils.card.list-item>
              @if($question->parent->name)
                <div> {{ $question->parent->name }} </div>
              @else
                <questions-tiptap-mini :initial-content="`{{ $question->body }}`" />
              @endif
            </x-utils.card.list-item>
            @endforeach
        </x-utils.card.list>
      </x-base.card>
    </div>
  </x-base.layout.container>
@endsection
