<input
  {{ $attributes->merge([
    'class' => "rounded h-10 px-2 w-full
                focus:border-blue-500 focus:border-2 focus:ring-0
                disabled:text-opacity-60 disabled:text-white
                border-black border-opacity-20 border-1
                dark:border-white dark:border-opacity-10 dark:border-1
                bg-dark bg-opacity-10
                dark:bg-black dark:bg-opacity-30",
    'type' => 'file'
  ]) }}
>
