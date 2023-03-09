<nav class="h-16 bg-indigo-800 w-full flex text-white px-4">
  <a class="my-auto mr-8">
    <h2 class="font-medium text-lg  text-white">
      Evaluaciones Preusm
    </h2>
    <h3 class="text-sm pl-1 text-white text-opacity-90">
      {{ __('collaborators') }}
    </h3>
  </a>
  <div class="ml-auto"></div>
  <div class="flex items-center">
    @if(Auth::user())
      <form action="/logout" method="POST">
        @csrf
        <button>
          {{ __('logout') }}
        </button>
      </form>
    @else
      <a class="mx-2" href="/login">
        {{ __('log in') }}
      </a>
    @endif
  </div>
</nav>
