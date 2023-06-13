<template>
  <slot />
</template>
<script>
import { Previewer } from 'pagedjs';
// import '../../../../node_modules/pagedjs/dist/paged.polyfill.js';

export default {
  mounted() {
    setTimeout(() => {
      let paged = new Previewer();
      paged.preview();
    }, 3000);
  },
};
</script>

<style href="../../../css/print.css" />
