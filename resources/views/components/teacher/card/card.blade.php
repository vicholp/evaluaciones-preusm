@props([
  'header' => null,
  'footer' => null,
  'padding' => true,
])

<div @class(['bg-white rounded shadow text-opacity-80 text-black
  dark:text-opacity-80 dark:bg-gray-800 dark:text-white dark:shadow-none',
  'p-6' => $padding
  ])
>
  @if($header)
    <h3 class="font-medium">
      {{ $header }}
    </h3>
    <div class="mb-4"></div>
  @endif
  <div>
    @isset($slot)
      {{ $slot }}
    @else
      {{ __('there is no data to show') }}
    @endisset
  </div>
  @if ($footer)
  <div class="text-black text-opacity-60 dark:text-white dark:text-opacity-60 mt-4">
    {{ $footer }}
  </div>
  @endif
</div>
