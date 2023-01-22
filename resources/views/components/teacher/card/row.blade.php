<div class="grid grid-cols-12">
  <div class="col-span-4"> {{ $key }} </div>
  <div class="col-span-8">
    @isset($value)
      @if($value === false)
        <i>false</i>
      @elseif($value === true)
        <i>true</i>
      @elseif(is_array($value))
        @json($value)
      @else
        {{ $value }}
      @endif
    @else
      <i>null</i>
    @endisset
  </div>
</div>
