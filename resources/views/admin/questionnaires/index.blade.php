@extends('admin.template.main')

@section('content')
  <x-base.layout.container>
    <x-base.layout.title-bar title="ensayos">
      <x-slot:actions>
        <v-dropdown title="Crear">
          <v-dropdown-item
            href="{{ route('admin.questionnaires.create') }}"
            body="{{ __('create') . ' ' . __('questionnaire') }}"
          ></v-dropdown-item>
          <v-dropdown-item
            href="{{ route('admin.questionnaires.create-from-prototype') }}"
            body="{{ __('create questionnaire from prototype') }}"
          ></v-dropdown-item>
        </v-dropdown>
      </x-slot:actions>
    </x-base.layout.title-bar>
    <div class="col-span-12 flex flex-col gap-3">
      <x-base.card padding="false">
        <x-base.table>
          <x-slot:header>
            <div class="col-span-4">
              {{ __('questionnaires') }}
            </div>
            <div class="col-span-4">
              {{ __('prototype') }}
            </div>
            </x-slot:table>
            @foreach ($questionnaires as $questionnaire)
              <a href="{{ route('admin.questionnaires.show', [$questionnaire]) }} ">
                <x-base.table.row>
                  <div class="col-span-4">
                    {{ $questionnaire->name ?? 'sin nombre' }}
                  </div>
                  <div class="col-span-4">
                    @if ($questionnaire->prototype)
                      {{ $questionnaire->prototype?->name }}
                    @else
                      {{ __('no prototype') }}
                    @endif
                  </div>
                </x-base.table.row>
              </a>
            @endforeach
        </x-base.table>
      </x-base.card>
    </div>
  </x-base.layout.container>
@endsection
