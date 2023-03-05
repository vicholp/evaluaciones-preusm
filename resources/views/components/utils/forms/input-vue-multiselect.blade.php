@props([
  'attribute',
  'model' => null,
  'name' => $attribute,
  'value' => null,
  'options' => [],
  'nameAttribute' => 'name',
  'keyAttribute' => 'id'
])

<x-teacher.forms.input attribute="{{ $attribute }}">
    <div class="col-span-8">
        <vue-multiselect name="{{ $name }}" :options='@json($options)' ></vue-multiselect>
    </div>
</x-teacher.forms.input>
