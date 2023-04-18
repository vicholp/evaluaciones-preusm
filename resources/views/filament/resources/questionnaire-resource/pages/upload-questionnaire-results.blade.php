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
        method="POST" id="form-questionaire"
        enctype="multipart/form-data"
        action={{ route('admin.questionnaires.import-results', $questionnaire) }}
      >
        @csrf
        <div class="flex flex-col gap-4 p-3">
          <div class="grid grid-cols-12 items-center">
            <div class="col-span-4 text-black text-opacity-90">numero de preguntas</div>
            <input type="number" value="65" name="questions" class="col-span-8 rounded h-full">
          </div>
          <div class="h-5">
          </div>
          <div class="grid grid-cols-12 items-center ">
            <div class="col-span-4 text-black text-opacity-90">respuestas de aula</div>
            <input type="file" name="file_answers" class="col-span-8 rounded h-full">
          </div>
          <div class="grid grid-cols-12 items-center">
            <div class="col-span-4 text-black text-opacity-90">csv de formscanner</div>
            <input type="file" name="file_formscanner" class="col-span-8 rounded h-full" accept=".csv">
          </div>
          <div class="h-10">
          </div>
          <div class="grid grid-cols-12 items-center">
            <div class="col-span-4 text-black text-opacity-90">ficha</div>
            <input type="file" name="file_tags" class="col-span-8 rounded h-full">
          </div>
        </div>
        <x-filament::button type="submit">
          Upload
        </x-filament::button>
      </form>
    </div>
  </x-filament::card>
</x-filament::page>
