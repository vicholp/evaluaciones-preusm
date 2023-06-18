@if ($errors->any())
  <x-base.card
    :header="__('errors')"
    color="bg-red-400 text-opacity-80 text-black shadow-red-500"
    dark-color="dark:bg-red-900 dark:text-opacity-80 dark:text-white dark:text-opacity-90 dark:shadow-none"
  >
    <x-base.list>
      @foreach ($errors->all() as $error)
        <x-base.list.item :body="$error" />
      @endforeach
    </x-base.list>
  </x-base.card>
@endif
