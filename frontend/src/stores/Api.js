import { defineStore } from "pinia";
import axios from "../lib/axios.js";
import { useMiscellaneousStore } from "./Miscellaneous.js";

export const useApiStore = defineStore("api", {
  state: () => ({
    brandLoading: false,
    categoryLoading: false,
    supplierLoading: false,
    productLoading: false,
    filterLoading: false,
  }),
  actions: {
    async getProducts(page = 1, perPage = 10, search = "", filters = []) {
      console.log('filters -> ',filters)
      this.productLoading = true;
      try {
        const response = await axios.get("/products", {
          params: {
            page,
            perPage,
            search,
            filters: filters.length > 0 ? JSON.stringify(filters) : "[]",
          },
        });

        return [response.data, response.data.data];
      } catch (err) {
        throw new Error(err.message);
      } finally {
        this.productLoading = false;
      }
    },
    async getBrands() {
      this.brandLoading = true;
      try {
        const response = await axios.get("/brands");
        return response.data;
      } catch (err) {
        throw new Error(err.message);
      } finally {
        this.brandLoading = false;
      }
    },
    async getCategories() {
      this.categoryLoading = true;
      try {
        const response = await axios.get("/categories");
        return response.data;
      } catch (err) {
        throw new Error(err.message);
      } finally {
        this.categoryLoading = false;
      }
    },
    async getSuppliers() {
      this.supplierLoading = true;
      try {
        const response = await axios.get("/suppliers");
        return response.data;
      } catch (err) {
        throw new Error(err.message);
      } finally {
        this.supplierLoading = false;
      }
    },
    async getDataForFilters() {
      const miscellaneousStore = useMiscellaneousStore();

      this.filterLoading = true;
      try {
        const response = await axios.get("/filters");
        const categories = response.data.categories;
        const brands = response.data.brands;
        const suppliers = response.data.suppliers;
        miscellaneousStore.maxValue = response.data.maxPrice;
        miscellaneousStore.minValue = response.data.minPrice;
        miscellaneousStore.mappedPrices = response.data.mappedPrices;
        miscellaneousStore.intervalWidth = response.data.intervalWidth;
        return [categories, brands, suppliers];
      } catch (err) {
        throw new Error(err.message);
      } finally {
        this.supplierLoading = false;
      }
    },
  },
});
