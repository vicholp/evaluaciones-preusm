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

  <link
    rel="stylesheet"
    href="{{ mix('css/print.css') }}"
  >

  <style>
    @page :first {
      @top-left {
        content: "{{ str($questionnaire->subject->name)->ucfirst() }}";
      }
    }
  </style>

  @stack('import_head')
</head>
<body>
  <div
    id="app"
    class="h-full font-[Arial]"
  >
    <div class="flex flex-col items-center gap-10">
      <div class="print:break-after-page">
        <x-teacher.instructions-questionnaire.general :questionnaire="$questionnaire" />
        <x-teacher.questionnaire.printView :questionnaire="$questionnaire" />
      </div>
      @foreach ($questionsSorted as $question)
        <div class="flex flex-row gap-5 print:break-inside-avoid">
          <div class="text-2xl font-medium">
            {{ $loop->index + 1 }}.
          </div>
          <div class="mt-1 w-[640px]">
            <teacher-question-bank-questions-tiptap
              :initial-content="`{{ Str::replace('\\', '\\\\', $question['item']->body) }}`"
              :editable="false"
              :with-style="false"
            ></teacher-question-bank-questions-tiptap>
          </div>
        </div>
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

  <script
    defer
    src="https://unpkg.com/pagedjs/dist/paged.polyfill.js"
  ></script>

  @stack('import_foot')
</body>

</html>
