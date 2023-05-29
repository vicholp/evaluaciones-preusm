@extends('admin.template.main')

@section('content')

<x-base.layout.container>
  <div class="col-span-6 flex flex-col gap-3">
    <x-base.card :header="__('users')" :route="route('admin.users.index')">
      <x-base.list>
        <x-base.list.key-value key="users" :value="$users->count()" />
      </x-base.list>
    </x-base.card>
  </div>
  <div class="col-span-6 flex flex-col gap-3">
    <x-base.card :header="__('questionnaires')" :route="route('admin.questionnaires.index')">
      Mas
    </x-base.card>
  </div>
</x-base.layout.container>
@endsection
