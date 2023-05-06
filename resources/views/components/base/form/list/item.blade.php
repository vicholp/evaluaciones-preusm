{{--

For example:

<x-base.form.list.item attribute="asdfk_asdf_id" input="text" />
<x-base.form.list.item attribute="asdfk_asdf_id" input="checkbox" />
<x-base.form.list.item attribute="asdf" input="text" name="sdf" type="number" value="2" />

--}}

@props([
  'attribute',
  'name' => $attribute,
  'input',
])

<div class="grid grid-cols-12 items-center py-4">
  <div class="col-span-4">
    {{ str($attribute)->snake()->replace('_', ' ')->ucfirst() }}
  </div>
  <div class="col-span-8">
    <x-dynamic-component :component="'base.form.input-' . $input" {{ $attributes }} name="{{ $name }}" />
  </div>
</div>
