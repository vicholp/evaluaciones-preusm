@extends('admin.template.main')

@section('content')
  <x-base.layout.container>
    <x-base.layout.title-bar
      :title="__('upload results')"
      :previus-route="route('admin.questionnaires.index')"
    >
      <x-slot:actions>
        <x-base.action
          :href="route('teacher.results.questionnaires.show', $results->questionnaire)"
          :body="__('results')"
        />
      </x-slot:actions>
    </x-base.layout.title-bar>
    <div class="col-span-12 flex flex-col gap-3">
      <x-base.card header="results">
        <x-base.list :divide="false">
          <x-base.list.key-value
            :key="__('questionnaire')"
            :value="$results->questionnaire->name"
          />
          <x-base.list.key-value
            :key="__('subject')"
            :value="$results->questionnaire->subject->name"
          />
          <x-base.list.separator />
          <x-base.list.key-value
            :key="__('results')"
            :value="$results->childs->count()"
          />
          <x-base.list.key-value
            :key="__('success')"
            :value="$results->childs->where('result', 'success')->count()"
          />
          <x-base.list.key-value
            :key="__('errors')"
            :value="$results->childs->where('result', '!=', 'success')->count()"
          />
        </x-base.list>
      </x-base.card>
      <x-base.card padding="false">
        <x-base.table>
          @foreach ($results->childs as $result)
            <x-base.table.row>
              <div class="col-span-3">
                {{ $result->data['filename'] ?? '' }}
              </div>
              <div class="col-span-3">
                {{ $result->data['rut'] ?? ($result->data['email'] ?? '') }}
              </div>
              <div class="col-span-1"> {{ $result->result }}</div>
              <div class="col-span-5"> {{ $result->result != 'success' ? collect($result->log)->join(', ') : 'OK' }} </div>
            </x-base.table.row>
          @endforeach
        </x-base.table>
      </x-base.card>
    </div>
  </x-base.layout.container>
@endsection
