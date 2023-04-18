<x-filament::page>
  @if ($errors->any())
    <x-filament::card>
      <div class="bg-red-200 p-3 col-span-12 rounded">
        <ul>
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    </x-filament::card>
  @endif
  <x-filament::card>
    <div class="col-span-12 flex flex-col gap-3">
      <form
        method="POST" id="form-users"
        enctype="multipart/form-data"
        action={{ route('admin.upload.users') }}
      >
        @csrf
        <div class="flex flex-col gap-4 p-3">
          <div class="grid grid-cols-12 items-center">
            <div class="col-span-4 text-black text-opacity-90">tipo de usuario</div>
            <select type="select"  name="role" class="col-span-8 rounded h-full">
              <option value="student">Estudiante</option>
              <option value="teacher">Profesor</option>
              <option value="admin">Administrador</option>
              <option value="user">Usuario</option>
            </select>
          </div>
          <div class="h-2">
          </div>
          <div class="grid grid-cols-12 items-center ">
            <div class="col-span-4 text-black text-opacity-90">usuarios</div>
            <input type="file" name="file" class="col-span-8 rounded h-full">
          </div>
        </div>
        <x-filament::button type="submit">
          Upload
        </x-filament::button>
      </form>
    </div>
  </x-filament::card>
</x-filament::page>
