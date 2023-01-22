@props(['actions' => null, 'name', 'previusRoute' => null])

<div class="col-span-12 flex flex-row items-center gap-3">
  <div class="font-medium text-lg p-2 text-opacity-80 text-black">
    @if ($previusRoute)
      <a href="{{ $previusRoute }}" class="dark:text-white dark:text-opacity-90 flex gap-3 items-center">
        <span class="iconify-inline text-xl" data-icon="mdi:arrow-left"></span>
        {{ $name }}
      </a>
    @else
      <h3 class="dark:text-white dark:text-opacity-90">
        {{ $name }}
      </h3>
    @endif
  </div>
  <div class="ml-auto"></div>
  {{ $actions }}
</div>
