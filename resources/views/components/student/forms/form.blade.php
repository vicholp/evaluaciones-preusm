@props([
  'action',
  'method',
  'id',
  'body'
])

<form class="flex flex-col gap-3" action="{{ $action }}" method="{{ $method == 'GET' ? 'GET' : 'POST' }}" id="{{ $id }}">
  @csrf
  @method($method)

  {{ $slot }}
</form>
