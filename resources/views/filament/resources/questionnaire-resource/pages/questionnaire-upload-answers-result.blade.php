<x-filament::page>
    <x-filament::card>
      <div class="col-span-12 bg-white rounded shadow p-3 flex flex-col gap-3">
        <x-teacher.card.card>
          <x-slot:header>
            <div class="px-6 py-3 font-medium grid grid-cols-12 bg-black bg-opacity-5 text-black text-opacity-90">
              <div class="col-span-4">
                {{ __('student') }}
              </div>
              <div class="col-span-3">
                {{ __('result') }}
              </div>
              <div class="col-span-3">
                {{ __('subtopic') }}
              </div>
            </div>
          </x-slot>
          <div class="flex flex-col py-3">
            @foreach($result->childs as $studentResult)
              <a class="px-6 py-3 grid grid-cols-12 bg-black bg-opacity-0 hover:bg-opacity-5">
                <div class="col-span-4">
                  {{-- @foreach($studentResult->log as $questionResult) --}}
                    {{-- {{ $questionResult }} <br> --}}
                  {{-- @endforeach --}}
                  {{ $studentResult->data['rut'] }}
                </div>
                <div class="col-span-3">
                  {{ $studentResult->result }}
                </div>
                <div class="col-span-3">
                  {{-- {{ $question->subtopic->name }} --}}
                </div>
                <div class="col-span-3">
                  {{-- {{ $question->stats()->getAverageScore() }} --}}
                </div>
              </a>
            @endforeach
          </div>
        </x-teacher.card.card>
        <x-filament::button class="bg-green-500 hover:bg-green-600">
          Upload
        </x-filament::button>
      </div>
    </x-filament::card>
</x-filament::page>
