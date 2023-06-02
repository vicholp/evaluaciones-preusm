@extends('admin.template.main')

@section('content')
  <x-base.layout.container>
    <x-base.layout.title-bar title="askdjf" :previus-route="route('admin.index')">
      <x-slot:actions>
        <x-base.action href="{{ route('admin.users.upload') }}" :body="__('import')" icon="mdi-import"/>
        <x-base.action href="{{ route('admin.users.create') }}" :body="__('new')" icon="mdi-plus"/>
      </x-slot:actions>
    </x-base.layout.title-bar>
    <div class="col-span-12">
      <x-base.card :padding="false">
        <x-base.table>
          <x-slot:header>
            <div class="col-span-1">
              ID
            </div>
            <div class="col-span-5">
              {{ __('name') }}
            </div>
            <div class="col-span-4">
              Email
            </div>
            <div class="col-span-2">
              Role
            </div>
          </x-slot:header>
          @foreach ($users as $user)
            <a href="{{ route('admin.users.show', $user) }}">
              <x-base.table.row>
                <div class="col-span-1">
                  {{ $user->id }}
                </div>
                <div class="col-span-5">
                  {{ $user->name }}
                </div>
                <div class="col-span-4">
                  {{ $user->email }}
                </div>
                <div class="col-span-2">
                  {{ $user->role()->toString() }}
                </div>
              </x-base.table.row>
            </a>
          @endforeach
        </x-base.table>
      </x-base.card>
    </div>
  </x-base.layout.container>
@endsection
