<nav class="h-16 bg-indigo-800 w-full flex text-white px-4 gap-2">
  <a class="my-auto mr-8" href="{{ route('admin.index') }}">
    <h2 class="font-medium text-lg  text-white" hf>
      Evaluaciones Preusm
    </h2>
  </a>
  <div class="hidden">
  </div>
  <div class="ml-auto"></div>
  <div class="my-auto">
    {{ auth()->user()->name ?? 'guest' }}
  </div>
  <a class="my-auto bg-indigo-900 p-2 rounded" href="{{ route('auth.logout') }}">
    Log out
  </a>
</nav>
