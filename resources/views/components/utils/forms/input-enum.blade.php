@props([
  'attribute',
  'model' => null,
  'options' => [],
])

<div class="grid grid-cols-12 items-center text-black text-opacity-90 dark:text-white dark:text-opacity-80">
  <div class="col-span-4">{{ Str::of($attribute)->snake()->replace('_', ' ')->title() }}</div>
  <select name="{{ $attribute }}" class="col-span-8 rounded h-full dark:bg-white dark:bg-opacity-5" required>
    @foreach ($options as $option)
      <option value="{{ $option }}" class="dark:bg-gray-900" {{ ($model?->state === $option) ? 'selected' : '' }}>{{ Str::ucfirst($option) }}</option>
    @endforeach
  </select>
</div>
