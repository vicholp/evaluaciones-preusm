<template>
  <MenuItem
    as="null"
    class="block px-4 py-2 dark:text-gray-800"
  >
    <a
      v-if="href"
      :href="href"
    >
      <div class="w-full">
        {{ body }}
      </div>
    </a>
    <slot v-else />
  </MenuItem>
</template>
<script>

import { MenuItem } from '@headlessui/vue';

export default {
  components: {
    MenuItem,
  },
  props: {
    href: {
      type: String,
      required: false,
      default: "",
    },
    body: {
      type: String,
      required: false,
      default: 'Item',
    },
  },

};

</script>
