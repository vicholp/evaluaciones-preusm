@extends('admin.template.main')

@section('content')
  <div class="container mx-auto grid grid-cols-12 p-3 gap-3">
    <div class="col-span-12 flex flex-row items-center gap-3">
      <div class="font-medium text-lg p-2 rounded text-opacity-80 text-black items-center flex gap-3">
        <a href="{{ route('admin.users.index') }}">
          <span class="iconify-inline text-xl" data-icon="mdi:arrow-left"></span>
        </a>
        <h3 class="">
          upload users
        </h3>
      </div>
      <div class="ml-auto"></div>
    </div>
    <div class="col-span-6 col-start-4 card p-3">
      <form action="{{ route('admin.users.import') }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-3 items-center">
        @csrf
        <input type="file" name="file" required>
        <button type="submit" class="bg-blue-800 p-2 rounded text-white w-full">Upload</button>
      </form>
    </div>
  </div>
@endsection
