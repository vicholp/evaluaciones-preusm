@props(['questionnaire'])

<div class="flex flex-col gap-5">
  <div class="flex flex-col gap-4 border-2 border-black border-opacity-50 px-10 py-5">
    <h2 class="text-center text-2xl font-bold">
      ENSAYO GENERAL 1 – 2023
    </h2>
    <h3 class="text-center font-bold my-3">
      INSTRUCCIONES
    </h3>

    <ol class="list-decimal flex flex-col gap-1">
      <li>
        Esta prueba contiene 65 preguntas, de las cuales puede que un maximo de 5 sean usadas para experimentacion
        y, por lo tanto, no se considerarán en el puntaje final de la prueba Las preguntas tienen 4 o 5 opciones
        de respuesta (A, B, C, D y E) <b> donde solo una de ellas es correcta. </b>
      </li>
      <li>
        <b> Dispones de <x-teacher.questionnaire.duration :questionnaire="$questionnaire" /> para responder las 65 preguntas.</b> Este tiempo comienza después de la
        lectura de las instrucciones, una vez contestadas las dudas y completados los datos de la hoja de respuestas
      </li>
      <li>
        Las respuestas a las preguntas se marcan en la hoja de respuestas que se te entregó. Marca tu respuesta en la fila
        de celdillas <b> que corresponda al número de la pregunta que estás contestando. </b> Ennegrece completamente la
        celdilla, tratando de no salirte de sus márgenes. Hazlo <b>exclusivamente</b> con lápiz de grafito Nº 2 o portaminas HB.
      </li>
      <li>
        Puedes usar este folleto como borrador, pero <b>no olvides traspasar oportunamente tus respuestas a la hoja
        de respuestas.</b> Ten presente que para la evaluación se considerarán exclusivamente las respuestas marcadas
        en dicha hoja
      </li>
      <li>
        Cuida la hoja de respuestas. <b>No la dobles. No la manipules innecesariamente.</b> Escribe en ella solo los datos
        pedidos y las respuestas. Evita borrar para no deteriorarla. Si lo haces, límpiala de los residuos de goma
      </li>
      <li>
        Es <b>obligatorio</b> devolver la hoja de respuestas antes de abandonar la sala. Puedes llevarte este folleto.
      </li>
    </ol>
  </div>
  <div class="px-10 py-5">
    <h3 class="flex flex-row justify-center">
      <img
        class="h-24 opacity-90"
        src="{{ Vite::asset('public/images/logo_preu_negro.png') }}"
      >
    </h3>
  </div>
</div>
