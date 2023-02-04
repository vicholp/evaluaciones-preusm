@props(['header'])
<x-teacher.card.card :padding="false">
  <div class="px-6 py-3 font-medium grid grid-cols-12 text-black text-opacity-90 bg-black bg-opacity-5">
    {{ $header }}
  </div>
  <div class="flex flex-col py-3">
    {{ $slot }}
  </div>
</x-teacher.card.card>
