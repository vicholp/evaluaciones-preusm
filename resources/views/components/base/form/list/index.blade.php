{{--

This component is used to render a list of inputs.

For example:

<x-base.card header="aksjfkj" footer="askjfdkj">
  <x-base.form.list>
    <x-base.form.list.item attribute="asdfk_asdf_id" input="text" />
    <x-base.form.list.item attribute="asdfk_asdf_id" input="checkbox" />
    <x-base.form.list.item attribute="asdf" input="text" name="sdf" type="number" value="2" />
  </x-base.form.list>
</x-base.card>

--}}

<x-base.list :divide="false">
 {{ $slot }}
</x-base.list>
