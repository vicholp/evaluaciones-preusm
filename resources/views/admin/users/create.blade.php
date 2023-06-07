@extends('admin.template.main')

@section('content')
  <x-base.layout.container>
    <x-base.layout.title-bar
      title="nuevo usuario"
      :previus-route="route('admin.users.index')"
    >
      <x-slot:actions>
        <x-base.action
          type="submit"
          form="user-form"
          body="create"
          href="{{ route('admin.users.store') }}"
        />
      </x-slot:actions>
    </x-base.layout.title-bar>
    <div class="col-span-12">
      <x-base.form.errors />
    </div>
    <div class="col-span-12">
      <x-base.card>
        <x-base.form
          :action="route('admin.users.store')"
          method="POST"
          id="user-form"
        >
          <x-base.form.list>
            <x-base.form.list.item
              input="text"
              attribute="name"
              required
            />
            <x-base.form.list.item
              input="text"
              type="email"
              attribute="email"
              required
            />
            <x-base.form.list.item
              input="text"
              attribute="rut"
              required
            />
            <x-base.form.list.item
              input="text"
              type="password"
              attribute="password"
              required
            />
            <x-base.form.list.item
              input="select"
              :attribute="__('role')"
              name="role"
              empty="User"
              :options="$roles"
            />
            <x-base.form.list.item
              input="select-model"
              :attribute="__('subject')"
              empty="ninguno"
              name="subject_id"
              :options="$subjects"
            />
          </x-base.form.list>
        </x-base.form>

      </x-base.card>
    </div>
  </x-base.layout.container>
@endsection
