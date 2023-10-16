@props(['attribute', 'model' => null, 'name' => $attribute, 'value' => null, 'options' => [], 'nameAttribute' => 'name', 'keyAttribute' => 'id', 'empty' => false])

<select
  name="{{ $name }}"
  class="col-span-8 h-10 w-full rounded dark:bg-white dark:bg-opacity-5"
  {{ $attributes }}
>
  @if (is_array($options))
    @if ($empty)
      <option>{{ $empty }}</option>
    @endif
    @foreach ($options as $option)
      <option
        value="{{ $option }}"
        class="dark:bg-gray-900"
        @selected($value == $option)
      >{{ Str::ucfirst($option) }}</option>
    @endforeach
  @else
    @if ($empty)
      <option value="">{{ $empty }}</option>
    @endif
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
