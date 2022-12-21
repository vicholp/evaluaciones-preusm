<x-filament::page>
    <x-filament::card>
      @if ($errors->any())
        <div class="bg-red-200 p-3 col-span-12 rounded">
          <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif
      <div class="col-span-12 bg-white rounded shadow p-3 flex flex-col gap-3">
        <form
          method="POST" id="form-questionaire"
          enctype="multipart/form-data"
          action={{ route('admin.questionnaires.import-results', $questionnaire) }}
        >
          @csrf
          <div class="flex flex-col gap-4 p-3">
            <div class="grid grid-cols-12 items-center">
              <div class="col-span-4 text-black text-opacity-90">questions</div>
              <input type="number" name="n_questions" class="col-span-8 rounded h-full">
            </div>


            <div class="grid grid-cols-12 items-center">
              <div class="col-span-4 text-black text-opacity-90">file with tags</div>
              <input type="file" name="file_tags" class="col-span-8 rounded h-full">
            </div>
            <div class="grid grid-cols-12 items-center">
              <div class="col-span-4 text-black text-opacity-90">csv from formscanner</div>
              <input type="file" name="file_formscanner" class="col-span-8 rounded h-full" accept=".csv">
            </div>

            <div class="h-10">

            </div>
            <div class="grid grid-cols-12 items-center">
              <div class="col-span-4 text-black text-opacity-90">answers</div>
              <input type="file" name="file_answers" class="col-span-8 rounded h-full">
            </div>
            <div class="grid grid-cols-12 items-center">
              <div class="col-span-4 text-black text-opacity-90">file with grades</div>
              <input type="file" name="file_grades" class="col-span-8 rounded h-full">
            </div>
            <div class="grid grid-cols-12 items-center">
              <div class="col-span-4 text-black text-opacity-90">file with stats</div>
              <input type="file" name="file_stats" class="col-span-8 rounded h-full">
            </div>
          </div>
          <x-filament::button type="submit" class="bg-green-500 hover:bg-green-600">
            Upload
          </x-filament::button>
        </form>
      </div>
    </x-filament::card>
</x-filament::page>
