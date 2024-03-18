<template>
  <aside
    class="custom-transition fixed flex min-h-full w-16 flex-col gap-4 overflow-hidden border-r-[1px] sm:static"
    :class="{
      ' w-[length:var(--sidebar-width)]': sidebarStore.isOpen,
      ' w-[length:var(--sidebar-width-collapsed)]  ': !sidebarStore.isOpen,
    }"
  >
    <div class="text-nowrap p-3 pl-4 pb-2 relative border-b-2" >
      <PiniaLogo class="inline-block pr-3"> </PiniaLogo>
      <div class="inline-block">

        <span
          class="custom-transition mr-2 relative top-1 text-xl font-semibold text-slate-700"
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
      class="custom-transition relative top-0 flex items-center"
    >
      <button
        :class="{
          '-rotate-180': sidebarStore.isOpen,
        }"
        class="mr-[0.3rem] flex items-center"
        @click="sidebarStore.isOpen = !sidebarStore.isOpen"
      >
        <span
          class="material-icons custom-transition text-[2rem] text-slate-500 hover:translate-x-[0.2rem] hover:text-sky-500"
        >
          keyboard_double_arrow_right
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
  </aside>
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
