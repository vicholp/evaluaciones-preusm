@props([
  'title',
  'actions' => false,
  'previusRoute' => false
])

<div class="col-span-12 flex flex-row items-center gap-3">
  <div class="font-medium text-lg p-2 text-opacity-80 text-black">
    @if ($previusRoute)
      <a href="{{ $previusRoute }}" class="dark:text-white dark:text-opacity-90 flex gap-3 items-center">
        <span class="iconify-inline text-xl" data-icon="mdi:arrow-left"></span>
        {{ $title }}
      </a>
    @else
      <h3 class="dark:text-white dark:text-opacity-90 p-0.5">
        {{ $title }}
      </h3>
    @endif
  </div>
  <div class="ml-auto flex flex-row gap-3 items-center">
    {{ $actions }}
  </div>
</div>
