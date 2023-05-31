@extends('admin.template.main')

@section('content')
  <x-base.layout.container>
    <x-base.layout.title-bar title="upload users">
      <x-slot:actions>
        <x-base.action href="{{ route('admin.users.index') }}" :body="__('cancel')" icon="mdi-cancel"/>
        <x-base.action type="submit" form="form" href="{{ route('admin.users.import') }}" :body="__('import')" icon="mdi-tick"/>
      </x-slot:actions>
    </x-base.layout.title-bar>
    <div class="col-span-12">
      <x-base.form.errors />
    </div>
    <div class="col-span-12">
      <x-base.card>
        <x-base.form :action="route('admin.users.upload')" method="POST" enctype="multipart/form-data">
          <x-base.form.list>
            <x-base.form.list.item input="file" attribute="file" accept=".csv" required/>
            <x-base.form.list.item input="select" attribute="role" :options="$roles" empty="user" required/>
          </x-base.form.list>
        </x-base.form>
      </x-base.card>
    </div>
    <div class="col-span-12">
      <x-base.card header="users file">
        <x-base.list>
          <x-base.list.key-value key="name" value="string"/>
          <x-base.list.key-value key="email" value="string"/>
          <x-base.list.key-value key="rut" value="string"/>
          <x-base.list.key-value key="password" value="sometimes, string"/>
        </x-base.list>
      </x-base.card>
    </div>
  </x-base.layout.container>
@endsection
