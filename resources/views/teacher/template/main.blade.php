<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />

  <title>@yield('title', 'Evaluaciones PREUSM')</title>

  <meta
    name="viewport"
    content="width=device-width, initial-scale=1"
  >
  <meta
    name="description"
    content="@yield('meta_desc')"
  >
  <meta
    name="robots"
    content="@yield('meta_robots')"
  >
  <link
    rel="canonical"
    href="{{ Request::url() }}"
  >

  {!! \Sentry\Laravel\Integration::sentryTracingMeta() !!}

  @vite(['resources/css/app.css', 'resources/js/app.js'], 'build')

  @stack('import_head')
</head>

<body class="min-h-screen bg-gray-100 dark:bg-gray-900 dark:text-white">
  <div
    id="app"
    class="h-full"
  >
    @include('teacher.template.navbar')

    @yield('content')

    @include('teacher.template.footer')
  </div>

  @stack('import_foot')
</body>

</html>
