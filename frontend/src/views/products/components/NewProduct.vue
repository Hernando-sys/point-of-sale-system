<template>
  <div class="mt-5 flex flex-col gap-4">
    <div>
      <label for="product" class="mb-2 text-sm font-semibold text-gray-700">
        Product Name (*)</label
      >
      <input
        autocomplete="off"
        type="text"
        class="block w-full rounded-lg border-gray-300 bg-gray-50 p-2.5 text-sm outline outline-1 outline-gray-300 focus:outline-2 focus:outline-cyan-500"
        name="product"
        v-model="product.name"
        required
      />
    </div>
    <div>
      <label for="code" class="mb-2 text-sm font-semibold text-gray-700">
        Code</label
      >
      <input
        autocomplete="off"
        type="text"
        class="block w-full rounded-lg border-gray-300 bg-gray-50 p-2.5 text-sm outline outline-1 outline-gray-300 focus:outline-2 focus:outline-cyan-500"
        v-model="product.code"
        name="code"
        required
      />
    </div>
    <div class="flex gap-4">
      <div class="w-1/2">
        <label for="category" class="mb-2 text-sm font-semibold text-gray-700">
          Category (*)</label
        >
        <select
          name="category"
          v-model="product.category"
          class="block w-full rounded-lg border-gray-300 bg-gray-50 p-2.5 text-sm outline outline-1 outline-gray-300 focus:outline-2 focus:outline-cyan-500"
        >
          <option class="text-muted" value="" disabled selected hidden>
            Select a category
          </option>
          <option
            v-for="category in categories"
            :key="category.id"
            :value="category.id"
          >
            {{ category.name }}
          </option>
        </select>
      </div>
      <div class="w-1/2">
        <label for="brand" class="mb-2 text-sm font-semibold text-gray-700">
          Brand (*)</label
        >
        <select
          name="brand"
          v-model="product.brand"
          class="block w-full rounded-lg border-gray-300 bg-gray-50 p-2.5 text-sm outline outline-1 outline-gray-300 focus:outline-2 focus:outline-cyan-500"
        >
          <option class="text-muted" value="" disabled selected hidden>
            Select a brand
          </option>
          <option v-for="brand in brands" :key="brand.id" :value="brand.id">
            {{ brand.name }}
          </option>
        </select>
      </div>
    </div>
    <div>
      <label for="description" class="mb-2 text-sm font-semibold text-gray-700">
        Description</label
      >
      <textarea
        class="block w-full resize-none rounded-lg border-gray-300 bg-gray-50 p-2.5 text-sm outline outline-1 outline-gray-300 focus:outline-2 focus:outline-cyan-500"
        name="description"
        id=""
        rows="3"
        v-model="product.description"
      ></textarea>
    </div>
  </div>
</template>

<script setup>
import axios from "../../../lib/axios";
import { ref } from "vue";
const props = defineProps({
  categories: {
    type: Array,
    default: [],
  },
  brands: {
    type: Array,
    default: [],
  },
});

const product = ref({
  name: "",
  code: "",
  category: "",
  brand: "",
  description: "",
});
</script>

<style></style>
