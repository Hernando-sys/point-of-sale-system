<script setup>
import { Popover, PopoverButton, PopoverPanel } from "@headlessui/vue";
const props = defineProps({
  label: {
    type: String,
    default: "Seleccione",
  },
  state: {
    type: String,
    default: "HOLA",
  },
});
</script>

<template>
  <Popover v-slot="{ open }">
    <PopoverButton
      :class="open ? 'text-gray-700' : 'text-gray-600/90'"
      class="block w-full rounded-lg border-gray-300 bg-gray-50 p-2.5 text-sm outline outline-1 outline-gray-300 focus:outline-2 focus:outline-cyan-500"
    >
      <div class="relative flex items-center justify-between">
        <span>{{ props.label }}</span>
        <div
          class="text-slate-500 absolute text-xs italic opacity-0 left-[30%] md:opacity-100"
        >
          {{ props.state }}
        </div>
        <span class="material-icons"> expand_more </span>
      </div>
    </PopoverButton>

    <transition
      v-show="open"
      enter-active-class="transition duration-200 ease-out"
      enter-from-class="translate-y-1 opacity-0"
      enter-to-class="translate-y-0 opacity-100"
      leave-active-class="transition duration-150 ease-in"
      leave-from-class="translate-y-0 opacity-100"
      leave-to-class="translate-y-1 opacity-0"
    >
      <PopoverPanel class="absolute z-10" static>
        <div
          class="mt-1.5 min-w-52 rounded-md border border-gray-300 bg-white p-4 shadow-lg"
        >
          <slot name="menu-content"></slot>
        </div>
      </PopoverPanel>
    </transition>
  </Popover>
</template>
