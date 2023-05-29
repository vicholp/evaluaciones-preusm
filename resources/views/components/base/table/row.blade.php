{{--
  This component is used to display a table row inside a table.
--}}

@props([
  'link' => false,
])

@if($link)
  <a href="{{ $link }}">
@endif
  <div class="py-4 px-6 grid grid-cols-12 bg-black bg-opacity-0 hover:bg-opacity-5">
    {{ $slot }}
  </div>
@if($link)
  </a>
@endif
