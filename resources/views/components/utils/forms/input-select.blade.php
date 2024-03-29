@props([
  'attribute',
  'model' => null,
  'name' => $attribute,
  'value' => null,
  'options' => [],
  'nameAttribute' => 'name',
  'keyAttribute' => 'id'
])

<x-utils.forms.input attribute="{{ $attribute }}">
  <select name="{{ $name }}" class="col-span-8 rounded h-10 dark:bg-white dark:bg-opacity-5" {{ $attributes }}>
    @if(is_array($options))
      @foreach ($options as $option)
        <option
          value="{{ $option }}"
          class="dark:bg-gray-900"
          @selected($value == $option)
        >{{ Str::ucfirst($option) }}</option>
      @endforeach
    @else
      @foreach ($options as $option)
        <option
          value="{{ $option->$keyAttribute }}"
          class="dark:bg-gray-900"
          @selected($value == $option->$keyAttribute)
        >
          {{ Str::ucfirst($option->$nameAttribute) }}
        </option>
      @endforeach
    @endif
  </select>
</x-utils.forms.input>
