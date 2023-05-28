{{--
  This component is used to display a card with a header and a footer.

  @param string $header The header of the card.
  @param string $footer The footer of the card.

  Example:

    <x-base.card header="Header" footer="Footer">
      <p>Content</p>
    </x-base.card>

--}}

@props([
  'header' => false,
  'footer' => false,
  'actions' => false,
  'route' => false,

  'padding' => 'p-6',
  'color' => 'bg-white text-opacity-80 text-black shadow',
  'darkColor' => 'dark:bg-gray-800 dark:text-opacity-80 dark:text-white dark:shadow-none',
])

@if ($route)
  <a href="{{ $route }}">
@endif
  <div
    {{ $attributes->merge([
      'class' => "rounded-lg {$padding} flex flex-col gap-5
                  {$color}
                  {$darkColor}"
    ]) }}
  >
    @if($header)
      <div class="flex flex-row items-center">
        <h3 class="font-medium my-1">
          {{ $header }}
        </h3>
        @if ($actions)
          <div class="ml-auto flex flex-row items-center gap-2">
            {{ $actions }}
          </div>
        @endif
      </div>
    @endif
    @if($slot->isNotEmpty())
      <div>
        {{ $slot }}
      </div>
    @else
      <i>
        {{ __('there is no data to show') }}
      </i>
    @endif
    @if ($footer)
      @if (!is_string($footer) && $footer->attributes->get('empty', false))
        {{ $footer }}
      @else
        <div class="text-black text-opacity-60 dark:text-white dark:text-opacity-60 py-1">
          {{ $footer }}
        </div>
      @endif
    @endif
  </div>
@if ($route)
  </a>
@endif
