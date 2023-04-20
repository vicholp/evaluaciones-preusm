@props([
  'type' => 'a',
  'href',
  'method' => false,
  'color' => 'bg-indigo-800',
  'class' => 'rounded p-3 text-white inline-block',
  'body' => 'text',
  'icon' => false,
  'form' => false
])

@if($type == 'form')
  <form action="{{ $href }}" method="POST" hidden id="form-{{ $method }}">
    @csrf
    @METHOD($method)
  </form>
  <button type="submit" form="form-{{ $method }}" class="flex items-center gap-2 {{ $color }} {{ $class }}">
    @if ($icon)
      <span class="iconify text-lg" data-icon="{{ $icon }}"></span>
    @endif
    {{ $body }}
  </button>
@elseif($type == 'a')
  <a href="{{ $href }}" class="flex items-center gap-2 {{ $color }} {{ $class }}">
    @if ($icon)
      <span class="iconify text-lg" data-icon="{{ $icon }}"></span>
    @endif
    {{ $body }}
  </a>
@elseif($type == 'submit')
  <button type="submit" form="{{ $form }}" class="flex items-center justify-center gap-2 {{ $color }} {{ $class }}">
    {{ $body }}
  </button>
@endif
