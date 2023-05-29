@extends('teacher.template.main')

@section('content')
  <x-base.layout.container>
    <x-base.layout.title-bar
      :title="__('students')"
      :previus-route="route('teacher.index')"
    />
    <div class="col-span-12">
      <x-base.card :padding="false">
        <x-base.table>
          @foreach ($students as $student)
            <x-base.table.row :link="route('teacher.results.students.show', $student)">
              <div class="col-span-4">
                {{ $student->name }}
              </div>
            </x-base.table.row>
          @endforeach
        </x-base.table>
      </x-base.card>
    </div>
  </x-base.layout.container>
@endsection
