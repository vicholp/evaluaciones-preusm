<template>
  <div class="flex flex-row gap-2 justify-center">
    <button
      v-for="page in Array(totalPages).keys()"
      :key="page"
      :class="`rounded px-2 py-1 bg-black
              ${currentPage == page ? 'bg-opacity-30' : 'bg-opacity-5'}`"
      type="button"
      @click="goToPage(page+1)"
    >
      {{ page + 1 }}
    </button>
  </div>
</template>
<script>

export default {
  props: {
    initialPage: {
      type: Number,
      required: false,
      default: 1,
    },
    totalPages: {
      type: Number,
      required: true,
    },
  },
  emits: ['pageChanged'],
  data(){
    return {
      currentPage: this.initialPage - 1,
    };
  },
  methods: {
    goToPage(page) {
      this.currentPage = page - 1;
      this.$emit('pageChanged', page);
    },
  },
};
</script>
