<template>
  <button
    type="button"
    class=""
    :class="{ 'bg-black bg-opacity-10 rounded': active }"
    @click="$emit('do')"
  >
    <span
      class="iconify text-2xl"
      :data-icon="icon"
    />
  </button>
</template>
<script>

export default {
  props: {
    icon: {
      type: String,
      required: true,
    },
    active: {
      type: Boolean,
      default: false,
    },
    disabled: {
      type: Boolean,
      default: false,
    },
  },
  emits: ['do'],
};

</script>
