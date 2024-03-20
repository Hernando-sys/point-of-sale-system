<template>
  <div class="flex items-center justify-end text-gray-500">
    <button @click="getUser">GET USER</button>
    <button
      @click="authStore.logoutUser"
      class="flex items-center justify-center hover:text-gray-800"
    >
      <span class="material-icons"> logout </span>
      <span>Log out</span>
    </button>
  </div>
</template>

<script setup>
import axios from "../lib/axios";
import { useAuthStore } from "../stores/Auth.js";
const authStore = useAuthStore()
// authStore.logoutUser;
const getUser = async () => {
  try {
    console.log("getting user");
    const response = await axios.get("http://localhost:8000/api/user");
    console.log(response.data);
  } catch (e) {
    console.log(e);
  }
};
</script>

<style></style>
