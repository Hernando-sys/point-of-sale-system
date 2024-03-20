import { defineStore } from "pinia";
import axios from "../lib/axios.js";
import router from "../router/index.js"
export const useAuthStore = defineStore("auth", {
  state: () => ({ isLoggedIn: false }),
  actions: {
    getLoggedInStatus() {
      const check =
        JSON.parse(window.localStorage.getItem("isLoggedIn")) ?? false;
      if (check) {
        this.isLoggedIn = check;
      } else {
        this.isLoggedIn = false;
      }
      return this.isLoggedIn;
    },
    setLoggedInStatus(status) {
      this.isLoggedIn = status;
      window.localStorage.setItem("isLoggedIn", JSON.stringify(status));
      return;
    },
    async logoutUser() {
      console.log("logoutUser");
      try {
        await axios.get("/logout");
      } catch (err) {
      } finally {
        this.setLoggedInStatus(false);
        router.push({ name: "login" }); 
      }
    },
  },
});
