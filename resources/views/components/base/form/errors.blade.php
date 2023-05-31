@if ($errors->any())
  <div class="bg-red-600 p-6 rounded-lg">
    <ul>
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif
