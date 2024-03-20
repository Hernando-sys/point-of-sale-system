<template>
  <div
    class="custom-transition fixed flex min-h-full w-16 flex-col gap-4 overflow-hidden border-r-[1px] sm:static"
    :class="{
      ' w-[length:var(--sidebar-width)]': sidebarStore.isOpen,
      ' w-[length:var(--sidebar-width-collapsed)]  ': !sidebarStore.isOpen,
    }"
    @mouseover="sidebarStore.isOpenHover = true"
    @mouseleave="sidebarStore.isOpenHover = false"
  >
    <div class="relative text-nowrap border-b-2 p-3 pb-2 pl-4">
      <PiniaLogo class="inline-block pr-3"> </PiniaLogo>
      <div class="inline-block">
        <span
          class="custom-transition relative top-1 mr-2 text-xl font-semibold text-slate-700"
          :class="{
            'opacity-0': !sidebarStore.isOpen,
          }"
          >Point of Sale</span
        >
      </div>
    </div>

    <div
      :class="{
        'justify-center': !sidebarStore.isOpen,
        'justify-end': sidebarStore.isOpen,
        ' pr-2': sidebarStore.isOpen,
      }"
      class="custom-transition relative top-0"
    >
      <button
        :class="{}"
        class="group mr-[0.3rem] flex w-full justify-end"
        @click="sidebarStore.isOpenPin = !sidebarStore.isOpenPin"
      >
        <span class="opacity-0 text-cyan-600"> push_pin </span>
        <span
          class="material-icons custom-transition absolute right-4 rotate-[15deg] text-[1.6rem]  group-hover:text-[2rem]"
          :class="{
            'text-[2rem] text-cyan-500 ': sidebarStore.isOpenPin,
            'text-slate-500  ': !sidebarStore.isOpenPin,
            ' opacity-1': sidebarStore.isOpen,
            ' opacity-0': !sidebarStore.isOpen,
          }"
        >
          push_pin
        </span>
      </button>
    </div>
    <nav class="font-semibold text-gray-600">
      <NavItem
        v-for="item in sidebarStore.navItems"
        :key="item.label"
        :item="item"
        :isSidebarOpen="sidebarStore.isOpen"
        :isActive="item.to === currentPath || hasActiveChild(item)"
        :currentPath="currentPath"
      >
      </NavItem>
    </nav>
  </div>
</template>

<script setup>
import { ref, computed } from "vue";
import NavItem from "./NavItem.vue";
import { useRoute } from "vue-router";
import { useSidebarStore } from "../../stores/Sidebar";
import PiniaLogo from "./PiniaLogo.vue";
const sidebarStore = useSidebarStore();
const route = useRoute();
const currentPath = computed(() => route.name);

const hasActiveChild = (item) => {
  return item.children.some((child) => child.to === currentPath.value);
};
</script>

<style scoped>
.custom-transition {
  transition: ease-out 0.2s;
}
</style>
