<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />

  <title>{{ 'Evaluaciones PREUSM' }}</title>

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

  @vite(['resources/css/app.css', 'resources/js/app.js'])

  <style>
    @page :first {
      @top-left {
        content: "{{ str($questionnaire->subject->name)->ucfirst() }}";
      }
    }
  </style>
</head>

<body>
  <div
    id="app"
    class="h-full font-[Arial]"
  >
    <v-pagedjs>
      <div class="flex flex-col items-center gap-10">
        <div class="print:break-after-page">
          <x-teacher.instructions-questionnaire.general :questionnaire="$questionnaire" />
          <x-teacher.questionnaire.instructions :questionnaire="$questionnaire" />
        </div>
        @foreach ($questionsSorted as $question)
          <div class="flex flex-row gap-5 print:break-inside-avoid">
            <div class="text-2xl font-medium">
              {{ $loop->index + 1 }}.
            </div>
            <div class="mt-1 w-[640px]">
              <questions-tiptap
                :version-id="{{ $question['item']->id }}"
                :editable="false"
                :with-style="false"
              ></questions-tiptap>
            </div>
          </div>
        @endforeach
      </div>
    </v-pagedjs>
  </div>
</body>

</html>
