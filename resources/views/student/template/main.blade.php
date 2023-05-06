<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8"/>

    <title>@yield('title', 'Evaluaciones PREUSM')</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('meta_desc')">
    <meta name="robots" content="@yield('meta_robots')">
    <link rel="canonical" href="{{ Request::url() }}">

    {!! \Sentry\Laravel\Integration::sentryTracingMeta() !!}

    <link rel="stylesheet" href="{{ mix('css/app.css')}}">

    @stack('import_head')
  </head>
  <body class="bg-gray-100 dark:bg-gray-900 dark:text-white min-h-screen">
    <div id="app" class="h-full">
      @include('student.template.navbar')

      @yield('content')

      @include('student.template.footer')
    </div>

    <script defer src="{{mix('/js/manifest.js')}}"></script>
    <script defer src="{{mix('/js/vendor.js')}}"></script>
    <script defer src="{{mix('/js/app.js')}}"></script>

    @stack('import_foot')
  </body>
</html>
