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

  <link
    rel="stylesheet"
    href="{{ mix('css/app.css') }}"
  >

  @stack('import_head')
</head>

<body>
  <div
    id="app"
    class="h-full"
  >
    <div class="flex flex-col items-center gap-20">
      @foreach ($questionsSorted as $question)
        <div class="flex flex-row gap-5">
          <div class="text-2xl">
            {{ $loop->index + 1 }}.
          </div>
          <div class="mt-1 w-[640px]">
            <teacher-question-bank-questions-tiptap
              :initial-content="`{{ Str::replace('\\', '\\\\', $question['item']->body) }}`"
              :editable="false"
              :with-style="false"
            >
          </div>
        </div>
        </teacher-question-bank-questions-tiptap>
      @endforeach
    </div>
  </div>

  <script
    defer
    src="{{ mix('/js/manifest.js') }}"
  ></script>
  <script
    defer
    src="{{ mix('/js/vendor.js') }}"
  ></script>
  <script
    defer
    src="{{ mix('/js/app.js') }}"
  ></script>

  @stack('import_foot')
</body>

</html>
