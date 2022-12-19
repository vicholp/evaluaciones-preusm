@props(['header' => null])

<div class="bg-white rounded shadow">
  <div>
    {{ $header }}
  </div>
  <div>
    {{ $slot }}
  </div>
</div>
