<template>
  <div class="m-auto flex min-h-screen flex-col items-center justify-center bg-sky-100">
    <div>
      <form @submit.prevent="submitForm" method="POST">
        <div class="flex-col items-center justify-center gap-4 space-y-6">
          <div>
            <label for="email">Email</label>
            <input type="email" v-model="email" name="email" id="email" />
          </div>
          <div>
            <label for="password">Password</label>
            <input type="password" v-model="password" name="password" id="password" />
          </div>
          <div>
            <button class="rounded-md bg-indigo-400 px-4 py-2 text-white" type="submit">
              Submit
            </button>
          </div>
        </div>
      </form>
    </div>
    <div>
      <button @click="getUser">get user</button>
      <a href="" class="text-green-500"></a>
      <a href="" class="text-green-500"></a>
      <a href="" class="text-green-500"></a>
      <a href="" class="text-green-500"></a>
      <a href="" class="text-green-500"></a>
    </div>
  </div>
</template>
<script setup>
import { ref } from "vue";
import axios from "@/lib/axios";


const email = ref("");
const password = ref("");

const error = ref(null);


const submitForm = async () => {
  try {
    // Fetch CSRF token
    await axios.get('http://localhost:8000/sanctum/csrf-cookie');
    await axios.post('http://localhost:8000/login', {
      email: email.value,
      password: password.value,
    });

  } catch (e) {
    error.value = e;
    console.error(error.value);
  }
};




const getUser = async () => {
  try {
    await axios.get('http://localhost:8000/api/user')
  } catch (e) {
    error.value = e;
    console.error(error.value);
  }
};

</script>
