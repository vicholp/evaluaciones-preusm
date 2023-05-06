{{--

For example:

<x-base.pill body="sadf" />

--}}

@props([
  'body' => $slot,
  'padding' => 'p-3',
  'color' => 'bg-black bg-opacity-10 text-black text-opacity-90',
  'darkColor' => 'dark:bg-white dark:bg-opacity-10 dark:text-white dark:text-opacity-90',
  'icon' => false,
])

<div
  {{ $attributes->merge([
    'class' => "rounded-lg py-1 px-2 text-sm w-min h-min whitespace-nowrap flex flex-row items-center gap-2 {$padding}
                {$color}
                {$darkColor}"
  ]) }}
>
  @if ($icon)
    <span class="iconify text" data-icon="{{ $icon }}"></span>
  @endif
  {{ $body }}
</div>
