{{--
  This component is used to display a list item inside a list.

  For example:
  <x-teacher.card.list>
    <x-teacher.card.list-item>
      A
    </x-teacher.card.list-item>
    <x-teacher.card.list-item>
      B
    </x-teacher.card.list-item>
  </x-teacher.card.list>
--}}


<div class="flex flex-row items-center gap-3 py-4">
  {{ $slot }}
</div>
