{{--
  Container for the page content.
--}}

<div
  {{ $attributes->merge([
    'class' => "container mx-auto p-3 grid grid-cols-12 gap-3
                text-black text-opacity-90
                dark:text-white dark:text-opacity-90"
  ]) }}
>
  {{ $slot }}
</div>
