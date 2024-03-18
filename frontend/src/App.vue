<script setup>
import { RouterLink, RouterView } from "vue-router";
import Sidebar from "./components/sidebar/Sidebar.vue";
import Topbar from "./components/Topbar.vue";
import { useAuthStore } from "./stores/Auth.js";
import { watch } from "vue";
const authStore = useAuthStore();
</script>

<template>
  <div class="flex min-h-[100dvh]">
    <Sidebar v-if="authStore.isLoggedIn" class="bg-gray-100" />

    <div class="] flex flex-grow flex-col">
      <Topbar class="pl-[6rem] sm:pl-[2rem]" v-if="authStore.isLoggedIn" />

      <!-- Main Content -->
      <RouterView
        class="flex-grow"
        :class="{ 'pl-[6rem] sm:pl-[2rem]': authStore.isLoggedIn }"
      >
      </RouterView>
    </div>
  </div>
</template>

<style>
:root {
  --sidebar-width-collapsed: 4rem;
  --sidebar-width: 13rem;
  --primary-color: olive;
  --secondary-color: teal;
}
</style>
```
