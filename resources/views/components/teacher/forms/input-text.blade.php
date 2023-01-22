@props([
  'attribute',
  'model' => null,
  'type' => 'text',
  'required' => true,
])

<div class="grid grid-cols-12 items-center">
  <div class="col-span-4">{{ Str::of($attribute)->snake()->replace('_', ' ')->title() }}</div>
  <input type="{{ $type }}" class="col-span-8 rounded h-10 dark:bg-white dark:bg-opacity-5 mx-auto w-full" name="{{ $attribute }}" value="{{ $model?->$attribute ?? '' }}"
    @if($required) required @endif
  >
</div>
