import { defineStore } from "pinia";
import { computed } from "vue";
export const useMiscellaneousStore = defineStore("Other", {
  state: () => ({
    maxValue: 0,
    minValue: 0,
    mappedPrices: null,
    intervalWidth: null,
  }),
});
