<x-filament::page>
  <x-teacher.card.table>
    <x-slot:header>
      <div class="col-span-6">
        {{ __('student') }}
      </div>
      <div class="col-span-3">
        {{ __('result') }}
      </div>
    </x-slot>
      @foreach($result->childs as $studentResult)
        <x-teacher.card.table-row>
          <div class="col-span-6">
            {{ $studentResult->data['rut'] ?? $studentResult->data['email'] ?? null }}
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
        </x-teacher.card.table-row>
      @endforeach
  </x-teacher.card.table>
</x-filament::page>
