{{--
  This component is used to display a list inside a card.

  @param boolean $divide If true, the list will have a divider between each item.

  For example:
  <x-student.card.card>
    <x-student.card.list>
      <x-student.card.list-item>
        A
      </x-student.card.list-item>
      <x-student.card.list-item>
        B
      </x-student.card.list-item>
    </x-student.card.list>
  </x-student.card.card>
--}}

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
