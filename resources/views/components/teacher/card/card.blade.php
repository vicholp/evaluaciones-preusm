@props(['header' => null])

<div class="bg-white rounded shadow dark:bg-gray-800 text-black dark:text-white dark:text-opacity-80 text-opacity-80 dark:shadow-none p-6">
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
</div>
