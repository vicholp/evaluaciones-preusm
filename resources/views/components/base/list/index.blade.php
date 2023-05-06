{{--
  This component is used to display a list inside a card.

  @param boolean $divide If true, the list will have a divider between each item.

  For example:
  <x-base.card.card>
    <x-base.list>
      <x-base.list-item>
        A
      </x-base.list-item>
      <x-base.list-item>
        B
      </x-base.list-item>
    </x-base.list>
  </x-base.card.card>
--}}

@props([
  'divide' => 'divide-y divide-black dark:divide-white divide-opacity-5 dark:divide-opacity-5'
])

<div
  {{ $attributes->merge([
    'class' => "flex flex-col my-[-1rem]
                {$divide}"
  ]) }}
>
  @if($slot->isNotEmpty())
    {{ $slot }}
  @else
    <i>
      {{ __('there is no data to show') }}
    </i>
  @endif
</div>
