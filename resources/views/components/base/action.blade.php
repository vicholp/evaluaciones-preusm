@props([
    'type' => 'a',
    'href',
    'method' => 'POST',
    'form' => false,
    'body' => $slot ?? 'button',

    'padding' => 'p-3',
    'color' => 'bg-indigo-800 bg-opacity-100 text-white text-opacity-90 transition hover:bg-indigo-700',
    'darkColor' => 'dark:bg-indigo-800 dark:bg-opacity-100 dark:text-white dark:text-opacity-90 transition hover:bg-indigo-700',
    'icon' => false,
    'formId' => str()->uuid(),
])

@if ($type == 'form')
  <form
    action="{{ $href }}"
    method="POST"
    id="{{ $formId }}"
    hidden
  >
    @csrf
    @METHOD($method)
  </form>
  <button
    type="submit"
    form="{{ $formId }}"
    {{ $attributes->merge([
        'class' => "{$padding} {$color} {$darkColor} rounded-lg flex items-center gap-1",
    ]) }}
  >
    @if ($icon)
      <span
        class="iconify text-lg"
        data-icon="{{ $icon }}"
      ></span>
    @endif
    <div>
      {{ $body }}
    </div>
  </button>
@elseif($type == 'a')
  <a
    href="{{ $href }}"
    {{ $attributes->merge([
        'class' => "{$padding} {$color} {$darkColor} rounded-lg flex items-center gap-1",
    ]) }}
  >
    @if ($icon)
      <span
        class="iconify mr-1 text-lg"
        data-icon="{{ $icon }}"
      ></span>
    @endif
    <div>
      {{ $body }}
    </div>
  </a>
@elseif($type == 'submit')
  <button
    type="submit"
    form="{{ $form }}"
    {{ $attributes->merge([
        'class' => "{$padding} {$color} {$darkColor} rounded-lg flex items-center gap-1",
    ]) }}
  >
    @if ($icon)
      <span
        class="iconify text-lg"
        data-icon="{{ $icon }}"
      ></span>
    @endif
    <div>
      {{ $body }}
    </div>
  </button>
@endif
