@extends('teacher.template.main')

@section('content')
  <x-teacher.container>
    <x-teacher.layout.title-bar
      :name="__('questionnaire groups')"
      :previus-route="route('teacher.index')"
    ></x-teacher.layout.title-bar>
    <div class="col-span-12">
      <x-teacher.card.table>
        <x-slot:header>
          <div class="col-span-3">
            {{ __('name') }}
          </div>
        </x-slot>
        @foreach($questionnaireGroups as $questionnaireGroup)
          <a href="{{ route('teacher.results.questionnaire-groups.show', $questionnaireGroup)}} ">
            <x-teacher.card.table-row>
              <div class="col-span-3">
                {{ $questionnaireGroup->name }}
              </div>
              <div class="col-span-3">
                {{-- {{ $questionnaireGroup }} --}}
              </div>
              <div class="col-span-3">
                {{-- {{ $questionnaireGroup }} --}}
              </div>
            </x-teacher.card.table-row>
          </a>
        @endforeach
      </x-teacher.card.card>
    </div>
  </x-teacher.container>
@endsection
