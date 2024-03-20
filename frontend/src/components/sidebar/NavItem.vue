<template>
  <router-link
    v-if="!item.children.length"
    @click="sidebarStore.resetActive(item, props.isChildren)"
    :to="item.to"
    class="mb-1 flex items-center gap-2 rounded-sm px-4 py-2 text-gray-800  hover:bg-gray-200"
    :class="{
      'bg-cyan-200 font-bold  hover:!bg-cyan-200':
        props.isActive && !props.isChildren,
      'bg-gray-200 font-bold  ':
        props.isActive && props.isChildren,
      ' color_gray ':
        !props.isActive && props.isChildren,
    }"
  >
    <span
      v-if="item.icon"
      class="material-icons"
      :class="{
        'text-gray-700': props.isActive,
        'text-gray-500': !props.isActive,
        'text-2xl': props.isChildren,
        'text-2xl': !props.isChildren,
      }"
      >{{ item.icon }}</span
    >
    <span
      :class="{
        'opacity-0': !isSidebarOpen,
      }"
      class="custom-transition"
    >
      {{ item.label }}
    </span>
  </router-link>

  <Disclosure v-else>
    <DisclosureButton
      @click="sidebarStore.resetActive(item)"
      class="custom-transition mb-1 flex w-full items-center rounded-sm px-4 py-2 font-semibold hover:bg-slate-200"
      :class="{
        'bg-cyan-200 font-bold text-gray-800 hover:!bg-cyan-200': props.isActive,
      }"
    >
      <span
        v-if="item.icon"
        :class="{ 'text-gray-700': item.isOpen, 'text-gray-500': !item.isOpen }"
        class="material-icons mr-2 text-2xl"
        >{{ item.icon }}</span
      >
      <span
        class="flex-1 text-left text-gray-800 custom-transition"
        :class="{
          'opacity-0': !isSidebarOpen,
        }"
      >
        {{ item.label }}
      </span>
      <span
        class="material-icons custom-transition"
        :class="{
          'opacity-0': !isSidebarOpen,
          '-rotate-180': item.isOpen,
        }"
      >
        expand_more
      </span>
    </DisclosureButton>
    <div v-show="item.isOpen">
      <DisclosurePanel static>
        <NavItem
          v-for="child in item.children"
          :key="child.label"
          :item="child"
          :isSidebarOpen="isSidebarOpen"
          :isActive="child.to === currentPath"
          :isChildren="true"
        >
        </NavItem>
      </DisclosurePanel>
    </div>
  </Disclosure>
</template>

<script setup>
import { computed, onMounted, ref, watch } from "vue";
import { useRoute } from "vue-router";
import { Disclosure, DisclosureButton, DisclosurePanel } from "@headlessui/vue";
import NavItem from "./NavItem.vue";
import { useSidebarStore } from "../../stores/Sidebar";

const sidebarStore = useSidebarStore();
sidebarStore.resetActive;
const hasOpenChild = (item) => {
  return item.children.some((child) => child.isOpen);
};

const props = defineProps({
  item: Object,
  isSidebarOpen: Boolean,
  isActive: Boolean,
  currentPath: {
    type: String,
    default: null,
  },
  isChildren: {
    type: Boolean,
    default: false,
  },
});
</script>

<style>
.custom-transition {
  transition: ease-out 0.2s;
}
.color_gray{
  color: rgb(119, 119, 119);
}
</style>
