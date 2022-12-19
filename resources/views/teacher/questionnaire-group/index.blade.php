@extends('teacher.template.main')

@section('content')
  <x-teacher.container>
    <x-teacher.layout.title-bar
      :name="__('questionnaire groups')"
      :previus-route="route('teacher.index')"
    ></x-teacher.layout.title-bar>
    <div class="col-span-12">
    </div>
    <div class="col-span-12">
      <x-teacher.card.card>
        <x-slot:header>
          <div class="px-6 py-3 font-medium grid grid-cols-12 bg-black bg-opacity-5 text-black text-opacity-90">
            <div class="col-span-3">
              {{ __('questionnaire') }}
            </div>
        </x-slot>
        <div class="flex flex-col py-3">
          @foreach($questionnaireGroups as $questionnaireGroup)
            <a class="px-6 py-3 grid grid-cols-12 bg-black bg-opacity-0 hover:bg-opacity-5" href="{{ route('teacher.questionnaire-groups.show', $questionnaireGroup)}} ">
              <div class="col-span-3">
                {{ $questionnaireGroup->name }}
              </div>
              <div class="col-span-3">
                {{-- {{ $questionnaireGroup }} --}}
              </div>
              <div class="col-span-3">
                {{-- {{ $questionnaireGroup }} --}}
              </div>
            </a>
          @endforeach
        </div>
      </x-teacher.card.card>
    </div>
  </x-teacher.container>
@endsection
