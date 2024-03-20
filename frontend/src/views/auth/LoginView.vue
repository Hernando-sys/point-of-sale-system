<template>
  <div class="relative flex h-full">
    <LoginSvg class="absolute h-full w-full" viewBox="0 0 3840 2160"></LoginSvg>

    <div class="z-10 m-auto">
      <form
        @submit.prevent="handleLogin"
        class="flex min-w-[500px] flex-col gap-8 rounded-lg bg-white p-8 font-semibold text-gray-700"
      >
        <h1 class="text-center text-4xl font-bold">Login</h1>
        <div>
          <label for="email" class="block">Email</label>
          <input
            type="email"
            v-model="form.email"
            name="email"
            id="email"
            class="block w-full rounded-lg border-gray-300 bg-gray-50 p-2.5 text-sm outline outline-1 outline-gray-300 focus:outline-2 focus:outline-cyan-500"
          />
        </div>
        <div>
          <label for="password" class="block">Password</label>
          <input
            type="password"
            v-model="form.password"
            name="password"
            id="password"
            class="block w-full rounded-lg border-gray-300 bg-gray-50 p-2.5 text-sm outline outline-1 outline-gray-300 focus:outline-2 focus:outline-cyan-500"
          />
        </div>
        <div>
          <button
            class="rounded-lg bg-cyan-700 px-5 py-2.5 text-center font-medium text-white hover:bg-cyan-600"
            type="submit"
          >
            Submit
          </button>
        </div>
        <button @click.prevent="getUser" class="bg-white">Show user</button>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "@/lib/axios";
import router from "@/router";
import { useAuthStore } from "../../stores/Auth.js";
import LoginSvg from "../auth/components/LoginSvg.vue";
const authStore = useAuthStore();

const form = ref({
  email: "",
  password: "",
});

const handleLogin = async () => {
  try {
    await axios.get("http://localhost:8000/sanctum/csrf-cookie");
    await axios.post("http://localhost:8000/login", {
      ...form.value,
    });
    authStore.setLoggedInStatus(true);
    router.push("dashboard");
  } catch (e) {
    if (e.status === 422) {
      let message = "";
      for (const [key, value] of Object.entries(e.validation)) {
        message += `${value}\n`;
      }
      alert(message);
    } else {
      alert(e.message);
    }
  }
};

const getUser = async () => {
  try {
    const response = await axios.get("http://localhost:8000/api/user");
    console.log(response.data);
  } catch (e) {
    console.log(e);
  }
};

onMounted(() => {
  if (authStore.getLoggedInStatus()) {
    router.push("dashboard");
  }
});
</script>
<style></style>
./components/LoginSvg.vue/index.js
