@props([
  'attribute',
  'name' => $attribute,
  'model' => null,
  'type' => 'text',
  'value' => null
])

<x-teacher.forms.input attribute="{{ $attribute }}" >
  <input type="{{ $type }}" class="col-span-8 rounded h-10 dark:bg-white dark:bg-opacity-5 mx-auto w-full"
    name="{{ $name }}" value="{{ $model?->$attribute ?? $value }}"
    {{ $attributes }}
  >
</x-teacher.forms.input>
