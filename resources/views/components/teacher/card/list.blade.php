@props(['divide' => true])

<div @class([
  "flex flex-col",
  "divide-y divide-black dark:divide-white divide-opacity-5  dark:divide-opacity-5" => $divide,
])>
  @isset($slot)
    {{ $slot }}
  @else
    {{ __('there is no data to show') }}
  @endisset
</div>
