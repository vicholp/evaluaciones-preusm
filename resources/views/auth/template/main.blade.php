<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />

  <title>{{ __('login') }} - Evaluaciones Preusm</title>

  <meta
    name="viewport"
    content="width=device-width, initial-scale=1"
  >
  <meta
    name="robots"
    content="noindex, nofollow"
  />
  <link
    rel="canonical"
    href="{{ Request::url() }}"
  >
  {!! \Sentry\Laravel\Integration::sentryTracingMeta() !!}

  @vite(['resources/css/app.css', 'resources/js/app.js'])

  @stack('import_head')
</head>

<body class="min-h-screen bg-gray-100 dark:bg-gray-900 dark:text-white">
  <div id="app">
    @yield('content')
  </div>

  @stack('import_foot')
</body>

</html>
