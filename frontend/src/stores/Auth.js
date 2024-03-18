import { defineStore } from "pinia";

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
  },
});
