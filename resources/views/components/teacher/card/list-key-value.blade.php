@props(['secure' => false, 'key', 'value'])

<div class="grid grid-cols-12 py-4">
  <div class="col-span-4"> {{ $key }} </div>
  <div class="col-span-8">
    @isset($value)
      @if($value === false)
        <i>false</i>
      @elseif($value === true)
        <i>true</i>
      @elseif(is_array($value))
        @json($value)
      @else />
        @if($secure)
          <p style="white-space: pre-line;">{!! $value !!}</p>
        @else
          {{ $value }}
        @endif
      @endif
    @else
      <i>null</i>
    @endisset
  </div>
</div>
