{{--
  This component is used to display a table, using the card component.

  @param string $header The header of the table.

  For example:

  <x-teacher.card.table>
    <x-slot:header>
      <div class="col-span-3">
        Column A
      </div>
      <div class="col-span-3">
        Column B
      </div>
      <div class="col-span-3">
        Column C
      </div>
    </x-slot:table>
    <x-teacher.card.table-row>
      <div class="col-span-3">
        A
      </div>
      <div class="col-span-3">
        B
      </div>
      <div class="col-span-3">
        C
      </div>
    </x-teacher.card.table-row>
  </x-teacher.card.table>
--}}

@props(['header'])

<x-teacher.card.card :padding="false">
  <div class="px-6 py-3 font-medium grid grid-cols-12 text-black text-opacity-90 bg-black bg-opacity-5">
    {{ $header }}
  </div>
  <div class="flex flex-col py-3">
    {{ $slot }}
  </div>
</x-teacher.card.card>
