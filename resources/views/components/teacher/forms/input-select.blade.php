@props([
  'attribute',
  'model' => null,
  'name' => $attribute,
  'options' => [],
  'nameAttribute' => 'name',
  'keyAttribute' => 'id'
])

<x-teacher.forms.input attribute="{{ $attribute }}">
  <select name="{{ $name }}" class="col-span-8 rounded h-10 dark:bg-white dark:bg-opacity-5" {{ $attributes }}>
    @foreach ($options as $option)
      <option
        value="{{ $option->$keyAttribute }}"
        class="dark:bg-gray-900"
        @selected($model?->$name === $option->id)
      >
        {{ Str::ucfirst($option->$nameAttribute) }}
      </option>
    @endforeach
  </select>
</x-teacher.forms.input>
