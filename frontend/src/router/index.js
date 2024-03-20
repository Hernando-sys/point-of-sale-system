import { createRouter, createWebHistory } from "vue-router";
import LoginView from "../views/auth/LoginView.vue";
import DashboardView from "@/views/dashboard/DashboardView.vue";
import { useAuthStore } from "@/stores/Auth";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: "/login",
      name: "login",
      component: LoginView,
    },

    {
      path: "/",
      redirect: "/dashboard",
    },
    {
      path: "/dashboard",
      name: "dashboard",
      component: DashboardView,
    },
    {
      path: "/invoices",
      name: "invoices",
      component: () => import("../views/sales/pages/Invoices.vue"),
    },

    {
      path: "/quotations",
      name: "quotations",
      component: () => import("../views/sales/pages/Quotations.vue"),
    },
    {
      path: "/products",
      name: "products",
      component: () => import("../views/products/ProductsView.vue"),
    },
    {
      path: "/products/import", 
      name: "products-import",
      component: () => import("../views/products/pages/ProductsImport.vue"),
    },
    {
      path: "/sales-report",
      name: "sales-report",
      component: () => import("../views/reports/pages/ReportSales.vue"),
    },
    {
      path: "/products-report",
      name: "products-report",
      component: () => import("../views/reports/pages/ReportProducts.vue"),
    },
    {
      path: "/settings-company",
      name: "settings-company",
      component: () => import("../views/settings/pages/SettingsCompany.vue"),
    },
    {
      path: "/settings-invoice",
      name: "settings-invoice",
      component: () => import("../views/settings/pages/SettingsInvoices.vue"),
    },
    {
      path: "/settings-system",
      name: "settings-system",
      component: () => import("../views/settings/pages/SettingsSystem.vue"),
    },
    {
      path: "/:catchAll(.*)",
      redirect: "/dashboard",
    },
  ],
});
router.beforeEach((to, from, next) => {
  const authStore = useAuthStore();
  const isAuthenticated = authStore.getLoggedInStatus();

  if (to.name !== "login" && !isAuthenticated) {
    next({ name: "login" });
  } else if (to.name === "login" && isAuthenticated) {
    next({ name: "dashboard" });
  } else {
    console.log("going to: ", to.name);
    next();
  }
});
export default router;
