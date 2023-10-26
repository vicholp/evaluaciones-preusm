@extends('teacher.template.main')

@section('content')
  <div class="h-10">

  </div>
  <x-base.layout.navbar/>
  <x-base.layout.container>
    <x-base.layout.title-bar title="ksajf">
      <x-slot:actions>
        <x-base.action body="submit" href="kaSsjd" icon="mdi-close"/>
          <x-base.action type="form" body="submit" href="kaSsjd"  icon="mdi-close"/>
          <x-base.action type="submit" body="submit" href="kaSsjd" icon="mdi-close"/>

        </x-slot:actions>
    </x-base.layout.title-bar>
    <div class="col-span-6">
      <x-base.card header="aksjfkj" footer="askjfdkj">
        <x-slot:actions>
          <x-base.action body="submit" href="kaSsjd" padding="py-1 px-2" icon="mdi-close"/>
          <x-base.action type="form" body="submit" href="kaSsjd" padding="py-1 px-2" icon="mdi-close"/>
          <x-base.action type="submit" body="submit" href="kaSsjd" padding="py-1 px-2" icon="mdi-close"/>
        </x-slot:actions>
      </x-base.card>
    </div>
    <div class="col-span-6">
      <x-base.card header="aksjfkj" footer="askjfdkj">
        <x-slot:actions>
        </x-slot:actions>
        asd
      </x-base.card>
    </div>
    <div class="col-span-6">
      <x-base.card header="aksjfkj" footer="askjfdkj">
        <x-base.list header="aksjfkj" footer="askjfdkj">
          <x-base.list.item body="a" />
        </x-base.list>
      </x-base.card>
    </div>
    <div class="col-span-6">
      <x-base.card header="aksjfkj" footer="askjfdkj">
        <x-slot:actions>
        </x-slot:actions>
        asd
      </x-base.card>
    </div>
    <div class="col-span-6">
      <x-base.card header="aksjfkj" footer="askjfdkj">
        <x-base.form.input-text/>
        <x-base.form.input-text/>
        <x-base.form.input-text/>
      </x-base.card>
    </div>
    <div class="col-span-6">
      <x-base.card header="aksjfkj" footer="askjfdkj">
        asdasd
      </x-base.card>
    </div>
    <div class="col-span-12">
      <x-base.card header="aksjfkj" footer="askjfdkj">
        <x-base.form.list>
          <x-base.form.list.item attribute="asdfk_asdf_id" input="text" />
          <x-base.form.list.item attribute="asdfk_asdf_id" input="checkbox" />
          <x-base.form.list.item attribute="asdf" input="text" name="sdf" type="number" value="2" />
        </x-base.form.list>
      </x-base.card>
    </div>
    <div class="col-span-12 flex flex-row gap-3">
      <x-base.pill body="sadf" icon="mdi-close" />
      <x-base.pill body="sadas323rf" />
      <x-base.pill body="sadsadfasdff" />
      <x-base.pill body="sadf" />
      <x-base.pill body="sadf sadfjk lksdajh las" icon="mdi-close"/>
      <x-base.pill body="sadf" />
      <x-base.pill icon="mdi-close">
        askjdaklsjhd
      </x-base.pill>
      <x-base.pill icon="mdi-close">
        askjdaklsjhd
      </x-base.pill>
    </div>
      <div class="col-span-12 shadow-r">

      </div>
  </x-base.layout.container>
  <x-base.layout.footer />
@endsection
