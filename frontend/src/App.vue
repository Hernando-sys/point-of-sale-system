<script setup>
import { RouterLink, RouterView } from "vue-router";
import Sidebar from "./components/sidebar/Sidebar.vue";
import Topbar from "./components/Topbar.vue";
import { useAuthStore } from "./stores/Auth.js";
import { watch } from "vue";
const authStore = useAuthStore();
</script>

<template>
  <div class="flex min-h-[100dvh] " >
    <aside v-if="authStore.isLoggedIn" class="z-10  shadow-xl">
      <Sidebar class="bg-white"/>
    </aside>

    <div class="z-0 flex flex-grow flex-col bg-gray-100">
      <header class="p-8 pt-6 pb-0 pl-24 sm:pl-12" v-if="authStore.isLoggedIn">
        <Topbar />
      </header>

      <main
        class="flex-grow "
        :class="{ 'p-8 pl-24 sm:pl-8': authStore.isLoggedIn }"
      >
        <RouterView />
      </main>
    </div>
  </div>
</template>

<style>
*{
  box-sizing: border-box;
}
:root {
  --sidebar-width-collapsed: 4rem;
  --sidebar-width: 13rem;
  --primary-color: olive;
  --secondary-color: teal;
}
body {
  overflow-y: auto;
  scrollbar-gutter: stable;
}
</style>
```
