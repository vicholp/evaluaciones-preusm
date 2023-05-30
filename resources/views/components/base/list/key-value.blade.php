@props([
  'secure' => false,
  'key',
  'value',
  'link' => false
])

<div class="grid grid-cols-12 py-3">
  <div class="col-span-4"> {{ $key }} </div>
  <div class="col-span-8">
    @isset($value)
      @if ($link)
        <a
          href="{{ $link }}"
          class="flex items-center gap-2"
        >
      @endif
      @if ($value === false)
        <i>false</i>
      @elseif($value === true)
        <i>true</i>
      @elseif(is_array($value))
        @json($value)
      @else
        @if ($secure)
          <p style="white-space: pre-line;">{!! $value !!}</p>
        @else
          {{ $value }}
        @endif
      @endif
      @if ($link)
        <span
          class="iconify text-lg"
          data-icon="mdi:open-in-new"
        ></span>
        </a>
      @endif
    @else
      <i>null</i>
    @endisset
  </div>
</div>
