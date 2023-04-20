@props([
  'attribute',
])

<div class="grid grid-cols-12 items-center">
  <div class="col-span-4">{{ Str::of($attribute)->snake()->replace('_', ' ')->title() }}</div>
  {{ $slot }}
</div>
