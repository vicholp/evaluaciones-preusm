<template>
  <Menu
    as="div"
    class="relative inline-block text-left"
  >
    <div>
      <MenuButton
        class="inline-flex w-full items-center
          justify-center rounded-lg
          bg-gray-300 p-3  text-gray-900 shadow
          dark:bg-white dark:bg-opacity-20 dark:text-gray-100
          transition hover:bg-gray-400"
      >
        {{ title }}
        <span
          class="iconify text-xl"
          data-icon="mdi:chevron-down"
        />
      </MenuButton>
    </div>
    <transition
      enter-active-class="transition ease-out duration-100"
      enter-from-class="transform opacity-0 scale-95"
      enter-to-class="transform opacity-100 scale-100"
      leave-active-class="transition ease-in duration-75"
      leave-from-class="transform opacity-100 scale-100"
      leave-to-class="transform opacity-0 scale-95"
    >
      <MenuItems
        class="absolute right-0 z-10 mt-2 w-56 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
      >
        <div class="py-1">
          <slot />
        </div>
      </MenuItems>
    </transition>
  </Menu>
</template>

<script>
import {
  Menu,
  MenuButton,
  MenuItems,
} from '@headlessui/vue';

export default {
  components: {
    Menu,
    MenuButton,
    MenuItems,
  },
  props: {
    title: {
      type: String,
      // required: true,
      default: 'Button',
    },
  },
};
</script>
