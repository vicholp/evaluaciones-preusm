<template>
  <div>
    <div
      ref="domtoimage"
      class="w-[640px] pb-5 tiptap-to-image"
    >
      <teacher-question-bank-questions-tiptap
        v-if="questionPrototypeVersion"
        :initial-content="questionPrototypeVersion.body"
        :editable="false"
        :with-style="false"
      />
    </div>
  </div>
</template>
<script>

import html2canvas from 'html2canvas';
import questionPrototypeVersions
  from '../../../../api/teacher/question-bank/question-prototype-versions';

export default {
  props: {
    questionId: {
      type: Number,
      required: true,
    },
  },
  data() {
    return {
      questionPrototypeVersion: null,
    };
  },
  async mounted() {
    const version = (await questionPrototypeVersions.get(this.questionId)).data;

    this.questionPrototypeVersion = version;

    setTimeout(() => {
      // this.htmlToCanvas();
    }, 5000);
  },
  methods: {
    htmlToCanvas() {
      html2canvas(this.$refs.domtoimage).then(canvas => {
        this.$refs.domtoimage.innerHTML = '';

        const base64Canvas = canvas.toDataURL("image/jpeg").split(';base64,')[1];

        let content = `<img src="data:image/jpeg;base64,${base64Canvas}" />`;

        content = content.replace("#", '\\#');
        content = content.replace(":", '\\:');
        content = content.replace("~", '\\~');
        content = content.replace("=", '\\=');
        content = content.replace("}", '\\}');
        content = content.replace("{", '\\{');

        let base = `::${this.title}:: \n [html]${content} \n {=A ~B ~C ~D ~E} \n\n`;

        this.$refs.domtoimage.textContent = base;
      });
    },
  },
};
</script>
<style>
  .tiptap-to-image .frac-line {
    @apply mb-[-10px];
  }
</style>
