import { defineStore } from "pinia";

export const useSidebarStore = defineStore("sidebar", {
  state: () => ({
    isOpen: false,
    navItems: [
      {
        to: "dashboard",
        active: false,
        isOpen: false,
        label: "Dashboard",
        children: [],
        icon: "dashboard",
      },
      {
        to: "#",
        active: false,
        isOpen: false,
        label: "Sales",
        children: [
          {
            to: "invoices",
            active: false,
            isOpen: false,
            label: "Invoices",
            children: [],
            icon: "radio_button_unchecked",
          },
          {
            to: "quotations",
            active: false,
            isOpen: false,
            label: "Quotations",
            children: [],
            icon: "radio_button_unchecked",
          },
        ],
        icon: "point_of_sale",
      },
      {
        to: "products",
        active: false,
        isOpen: false,
        label: "Products",
        children: [],
        icon: "inventory_2",
      },
      {
        to: "#",
        active: false,
        isOpen: false,
        label: "Reports",
        children: [
          {
            to: "sales-report",
            active: false,
            isOpen: false,
            label: "Sales",
            children: [],
            icon: "radio_button_unchecked",
          },
          {
            to: "products-report",
            active: false,
            isOpen: false,
            label: "Products",
            children: [],
            icon: "radio_button_unchecked",
          },
        ],
        icon: "analytics",
      },
      {
        to: "#",
        active: false,
        isOpen: false,
        label: "Settings",
        children: [
          {
            to: "settings-company",
            active: false,
            isOpen: false,
            label: "Company",
            children: [],
            icon: "radio_button_unchecked",
          },
          {
            to: "settings-invoice",
            active: false,
            isOpen: false,
            label: "Invoices",
            children: [],
            icon: "radio_button_unchecked",
          },
          {
            to: "settings-system",
            active: false,
            isOpen: false,
            label: "System",
            children: [],
            icon: "radio_button_unchecked",
          },
        ],
        icon: "settings",
      },
    ],
  }),
  actions: {
    resetActive(selectedItem, isChild = false) {
      if(isChild){
        return
      }

      this.navItems.forEach((item) => {
        if (item.label === selectedItem.label) {
          item.isOpen = !item.isOpen; ;
        }else{
          item.isOpen = false;
        }
      });
    },
  },
});
