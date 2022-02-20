<nav class="h-16 bg-indigo-800 w-full flex text-white px-4">
  <a class="my-auto mr-8" href="{{ route('admin.index') }}">
    <h2 class="font-medium text-lg  text-white" hf>
      Admin page
    </h2>
  </a>
  <div class="hidden">
  </div>
  <div class="my-auto ml-auto">
    {{ auth()->user()->name }}
  </div>
</nav>
