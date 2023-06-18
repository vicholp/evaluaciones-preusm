@extends('admin.template.main')

@section('content')
  <x-base.layout.container>
    <x-base.layout.title-bar
      :title="__('students')"
      :previus-route="route('admin.users.index')"
    >
      <x-slot:actions>
        <x-base.action
          :href="route('admin.users.edit', $user)"
          :body="__('edit')"
          icon="mdi-pencil"
        />
      </x-slot:actions>
    </x-base.layout.title-bar>
    <div class="col-span-12">
      <x-base.card>
        <x-base.list :divide="false">
          <x-base.list.key-value
            :key="__('name')"
            :value="$user->name"
          />
          <x-base.list.key-value
            :key="__('email')"
            :value="$user->email"
          />
          <x-base.list.key-value
            :key="__('rut')"
            :value="$user->rut"
          />
          <x-base.list.key-value
            :key="__('rut dv')"
            :value="$user->rut_dv"
          />
          <x-base.list.key-value
            :key="__('created at')"
            :value="$user->created_at->diffForHumans()"
          />
          <x-base.list.key-value
            :key="__('updated at')"
            :value="$user->updated_at->diffForHumans()"
          />
          <x-base.list.separator />
          <x-base.list.key-value
            :key="__('teacher')"
            :value="$user->role()->isTeacher()"
          />
          <x-base.list.key-value
            :key="__('admin')"
            :value="$user->role()->isAdmin()"
          />
          <x-base.list.key-value
            :key="__('student')"
            :value="$user->role()->isStudent()"
          />
        </x-base.list>
      </x-base.card>
    </div>
  </x-base.layout.container>
@endsection
