import "./assets/app.css";

import { createApp } from "vue";
import { createPinia } from "pinia";
import App from "./App.vue";
import router from "./router";
import { useAuthStore } from "./stores/Auth";
const app = createApp(App);
const pinia = createPinia();
app.use(pinia);
const authStore = useAuthStore();
authStore.getLoggedInStatus();

app.use(router);

app.mount("#app");
