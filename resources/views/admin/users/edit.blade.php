@extends('admin.template.main')

@section('content')
  <x-base.layout.container>
    <x-base.layout.title-bar
      :title="__('edit') . ' ' . __('user')"
      :previus-route="route('admin.users.show', $user->id)"
    >
      <x-slot:actions>
        <x-base.action
          type="submit"
          form="user-form"
          :body="__('store')"
          icon="material-symbols:save"
        />
      </x-slot:actions>
    </x-base.layout.title-bar>
    <div class="col-span-12">
      <x-base.form.errors />
    </div>
    <div class="col-span-12">
      <x-base.card>
        <x-base.form
          :action="route('admin.users.update', $user)"
          method="PUT"
          id="user-form"
        >
          <x-base.form.list>
            <x-base.form.list.item
              input="text"
              attribute="name"
              :value="$user->name"
              required
            />
            <x-base.form.list.item
              input="text"
              type="email"
              attribute="email"
              :value="$user->email"
              required
            />
            <x-base.form.list.item
              input="text"
              attribute="rut"
              :value="$user->rut . '-' . $user->rut_dv"
              required
            />
            <x-base.form.list.item
              input="text"
              type="password"
              attribute="password"
              :placeholder="$user->password"
            />
          </x-base.form.list>
        </x-base.form>
      </x-base.card>
    </div>
  </x-base.layout.container>
@endsection
