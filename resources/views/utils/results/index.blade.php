@extends('utils.template.main')

@section('content')
  <x-utils.container>
    <div class="col-span-12">
      <a href="{{ route('utils.results.start') }}">
      <x-utils.card.card>
          Comenzar de cero
        </x-utils.card.card>
      </a>
    </div>
  </x-utils.container>
@endsection
