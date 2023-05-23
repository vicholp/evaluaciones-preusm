<template>
  <div class="flex flex-col gap-3">
    <div class="bg-white rounded shadow p-3">
      Progress: {{ progress }} / {{ nQuestions }} - {{ Math.round(fileSize/(1024**2)) }} MB
    </div>
    <div
      v-for="[id, q] in ids.entries()"
      :key="id"
      class="flex justify-center bg-white rounded shadow p-3"
    >
      <div class="w-[640px]">
        <div
          :ref="`domtoimage-${id}`"
          class="w-[640px] pb-5 pl-2"
        >
          <teacher-question-bank-questions-tiptap
            v-if="questions[id]?.body"
            :initial-content="questions[id].body"
            :editable="false"
            :with-style="false"
          />
        </div>
      </div>
    </div>
  </div>
</template>
<script>

import html2canvas from 'html2canvas';
import questionPrototypeVersions
  from '../../../../api/teacher/question-bank/question-prototype-versions';

import FileSaver from 'file-saver';

export default {
  props: {
    ids: {
      type: Array,
      required: true,
    },
  },
  data() {
    return {
      questions: Array(this.ids.length).fill({}),
      images: Array(this.ids.length).fill(''),
      progress: 0,
      nQuestions: this.ids.length,
      fileSize: 0,
    };
  },
  watch: {
    progress(){
      if (this.progress === this.nQuestions) {
        console.log('done');

        let content = this.images.join('');

        FileSaver.saveAs(new Blob([content], {type: "text/plain;charset=utf-8"}), "questions.txt");
      }
    },
  },
  async mounted() {
    for (const [i, id] of this.ids.entries()) {
      const question = (await questionPrototypeVersions.get(id)).data;
      this.questions[i] = question;
      setTimeout(() => {
        this.htmlToCanvas(i);
      }, 2000);
    }
  },
  methods: {
    htmlToCanvas(id) {
      const div = this.$refs[`domtoimage-${id}`][0];
      html2canvas(div, {scale: 3}).then(canvas => {
        const base64Canvas = canvas.toDataURL("image/jpeg").split(';base64,')[1];

        div.innerHTML = `<img src="data:image/jpeg;base64,${base64Canvas}" />`;

        let content = `<img src="data:image/jpeg;base64,${base64Canvas}" />`;

        content = content.replace("#", '\\#');
        content = content.replace(":", '\\:');
        content = content.replace("~", '\\~');
        content = content.replace("=", '\\=');
        content = content.replace("}", '\\}');
        content = content.replace("{", '\\{');

        let name = (id+1).toString().padStart(2, 0);
        let base = `::${name}:: \n[html]${content} \n{=A ~B ~C ~D ~E}\n\n`;

        this.images[id] = base;
        this.progress += 1;
        this.fileSize += base.length;
      });
    },
  },
};
</script>
<style>
  .frac-line {
    @apply mb-[-10px];
  }
</style>
