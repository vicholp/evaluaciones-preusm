<template>
  <div>
    <div
      ref="domtoimage"
      class="w-[640px]"
    >
      <teacher-question-bank-questions-tiptap
        :initial-content="body"
        :editable="false"
        :with-style="false"
      />
    </div>
  </div>
</template>
<script>

import html2canvas from 'html2canvas';

export default {
  props: {
    body: {
      type: String,
      required: true,
    },
  },

  mounted() {
    setTimeout(() => {
      this.downloadImage();
    }, 3000);
  },
  methods: {
    downloadImage() {
      html2canvas(this.$refs.domtoimage).then(canvas => {
        this.$refs.domtoimage.innerHTML = '';
        this.$refs.domtoimage.appendChild(canvas);

        // var link = document.createElement("a");
        // link.download = "c.png";
        // link.href = canvas.toDataURL();
        // link.target = '_blank';
        // link.click();
      });
    },
  },
};
</script>
