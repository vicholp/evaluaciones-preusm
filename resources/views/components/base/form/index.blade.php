@props([
  'action',
  'method',
  'id' => 'form',
  'body'
])

<form class="flex flex-col gap-3" {{ $attributes }}action="{{ $action }}" method="{{ $method == 'GET' ? 'GET' : 'POST' }}" id="{{ $id }}">
  @csrf
  @method($method)

  {{ $slot }}
</form>
