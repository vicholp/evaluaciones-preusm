<div class="flex flex-col divide-y divide-white divide-opacity-10">
  @isset($slot)
    {{ $slot }}
  @else
    {{ __('there is no data to show') }}
  @endisset
</div>
