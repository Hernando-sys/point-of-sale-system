<template>
  <div class="relative z-10 flex h-full flex-col overflow-hidden">
    <Modal :isOpen="openModal" @modal-closed="openModal = false">
      <template #modal-title> Create New Product </template>
      <template #modal-content>
        <NewProduct :brands="brands" :categories="categories" />
      </template>
    </Modal>

    <h1 class="z-10 flex items-end bg-gray-100 text-3xl font-bold">
      <span class="material-icons mr-3 text-3xl"> inventory_2</span>
      Productos
    </h1>
    <div class="z-10 flex items-center justify-end gap-5 bg-gray-100 py-4">
      <button
        @click="openModal = true"
        class="relative flex items-center justify-between rounded-md bg-cyan-700 p-2 pl-9 font-semibold text-white hover:bg-cyan-600"
      >
        <span class="absolute left-1">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            height="32"
            viewBox="0 -960 960 960"
            width="32"
            fill="white"
          >
            <path
              d="M440-440H200v-80h240v-240h80v240h240v80H520v240h-80v-240Z"
            />
          </svg>
        </span>
        Create New Product
      </button>
      <router-link
        class="justigy-between relative flex items-center rounded-md bg-cyan-700 p-2 pl-11 font-semibold text-white hover:bg-cyan-600"
        :to="{ name: 'products-import' }"
      >
        <span class="absolute left-2">
          <svg
            xmlns="http://www.w3.org/2000/svg"
            height="28"
            viewBox="0 -960 960 960"
            width="28"
            fill="white"
          >
            <path
              d="M320-240h320v-80H320v80Zm0-160h320v-80H320v80ZM240-80q-33 0-56.5-23.5T160-160v-640q0-33 23.5-56.5T240-880h320l240 240v480q0 33-23.5 56.5T720-80H240Zm280-520v-200H240v640h480v-440H520ZM240-800v200-200 640-640Z"
            />
          </svg>
        </span>
        Import Products
      </router-link>
    </div>

    <div class="z-10 bg-gray-100">
      <button
        class="flex items-center justify-between rounded-t-xl border border-gray-300 bg-gray-200 p-2 px-4"
        @click="hideButton = !hideButton"
        :class="{ 'border-b-0': hideButton }"
      >
        Show Filters
        <span class="material-icons"> arrow_drop_down </span>
      </button>
    </div>

    <div
      id="product_filters"
      class="flex w-full justify-evenly rounded-tr-xl bg-white p-4 transition-all duration-300"
      :style="{ 'margin-top': hideButton ? `-${elementHeight}px` : '0' }"
    >
      <Popover v-slot="{ open }" class="">
        <PopoverButton
          :class="open ? 'text-white' : 'text-white/90'"
          class="group relative inline-flex items-center rounded-md bg-orange-700 px-3 py-2 text-base font-medium hover:text-white focus:outline-none focus-visible:ring-2 focus-visible:ring-white/75"
        >
          <span>Solutions</span>
        </PopoverButton>

        <transition
          v-show="open"
          enter-active-class="transition duration-200 ease-out"
          enter-from-class="translate-y-1 opacity-0"
          enter-to-class="translate-y-0 opacity-100"
          leave-active-class="transition duration-150 ease-in"
          leave-from-class="translate-y-0 opacity-100"
          leave-to-class="translate-y-1 opacity-0"
        >
          <PopoverPanel class="absolute z-10" static>
            <div
              class="mt-1.5 overflow-hidden rounded-lg bg-red-400 p-4 shadow-lg"
            >
              <span class="flex items-center">
                <span class="text-sm font-medium text-gray-900">
                  Documentation
                </span>
              </span>
              <span class="block text-sm text-gray-500">
                Start integrating products and tools
              </span>
            </div>
          </PopoverPanel>
        </transition>
      </Popover>
      <Popover v-slot="{ open }" class="">
        <PopoverButton
          :class="open ? 'text-white' : 'text-white/90'"
          class="group relative inline-flex items-center rounded-md bg-orange-700 px-3 py-2 text-base font-medium hover:text-white focus:outline-none focus-visible:ring-2 focus-visible:ring-white/75"
        >
          <span>Solutions</span>
        </PopoverButton>

        <transition
          v-show="open"
          enter-active-class="transition duration-200 ease-out"
          enter-from-class="translate-y-1 opacity-0"
          enter-to-class="translate-y-0 opacity-100"
          leave-active-class="transition duration-150 ease-in"
          leave-from-class="translate-y-0 opacity-100"
          leave-to-class="translate-y-1 opacity-0"
        >
          <PopoverPanel class="absolute z-10" static>
            <div
              class="mt-1.5 overflow-hidden rounded-lg bg-red-400 p-4 shadow-lg"
            >
              <span class="flex items-center">
                <span class="text-sm font-medium text-gray-900">
                  Documentation
                </span>
              </span>
              <span class="block text-sm text-gray-500">
                Start integrating products and tools
              </span>
            </div>
          </PopoverPanel>
        </transition>
      </Popover>
    </div>
    <div
      class="rounded-b-xl border-t border-gray-300 bg-white p-4 shadow-md"
      :class="{ 'rounded-tr-xl': hideButton }"
    >
      <!-- Table captions and filter chips -->
      <div class="flex flex-col justify-evenly">
        <div class="my-1 flex flex-wrap">
          <span
            class="mr-2 mt-2 flex items-center py-1 text-xs font-semibold text-blue-800"
          >
            Filtros activos:
          </span>
          <div
            v-if="selectedFilters.length > 0"
            v-for="(filter, index) in selectedFilters"
            :key="index"
            class="mr-2 mt-2 flex items-center rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-800"
          >
            <span>{{ filter.name }}</span>
            <button class="ml-2 focus:outline-none">
              <svg
                class="h-3 w-3 cursor-pointer fill-current"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
              >
                <path
                  d="M10.586 12l-4.293-4.293a1 1 0 0 1 1.414-1.414L12 10.586l4.293-4.293a1 1 0 0 1 1.414 1.414L13.414 12l4.293 4.293a1 1 0 0 1-1.414 1.414L12 13.414l-4.293 4.293a1 1 0 0 1-1.414-1.414L10.586 12z"
                />
              </svg>
            </button>
          </div>
          <div v-else class="mr-2 mt-2 flex items-center py-1 text-xs">
            No hay filtros activos
          </div>
        </div>
        <div class="my-2 flex items-end justify-between">
          <div class="flex items-center">
            <span class="mr-2 text-sm">Mostrar:</span>
            <select
              v-model="perPage"
              id="entries"
              class="block w-full rounded-lg border-gray-300 bg-gray-50 p-2.5 py-2 text-sm outline outline-1 outline-gray-300 focus:outline-2 focus:outline-cyan-500"
            >
              <option value="5">5</option>
              <option value="10" selected>10</option>
              <option value="15">15</option>
              <option value="20">20</option>
            </select>
            <span class="ml-2 text-sm">filas</span>
          </div>
          <div class="mr-1">
            <div class="flex w-full">
              <input
                v-model="search"
                name="table_search"
                type="search"
                class="block w-full rounded-l-lg  border   border-gray-300 bg-gray-50 p-2.5 text-sm  outline-gray-300  focus:border-2 focus:border-cyan-500 focus:outline-none"
                placeholder="Buscar producto"
              />
              <!--Search button-->
              <button
                class="flex items-center bg-gray-200  border-l-0 border border-gray-300 rounded-l-none rounded-r-md p-2.5 text-sm text-white hover:bg-gray-300"
                type="button"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  height="24px"
                  viewBox="0 0 24 24"
                  width="24px"
                  fill="#000000"
                >
                  <path d="M0 0h24v24H0V0z" fill="none" />
                  <path
                    d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"
                  />
                </svg>
              </button>
            </div>
          </div>
        </div>
      </div>

      <!-- Table -->
      <div class="overflow-x-auto">
        <table
          class="mt-3 min-h-[150px] w-full text-nowrap text-left text-sm text-gray-500"
        >
          <thead class="bg-gray-100 text-sm uppercase text-gray-600">
            <tr>
              <th scope="col" class="px-4 py-3">Code</th>
              <th scope="col" class="px-4 py-3">Name</th>
              <th scope="col" class="px-4 py-3 text-right">Price</th>
              <th scope="col" class="px-4 py-3 text-right">Cost</th>
              <th scope="col" class="px-4 py-3"></th>
            </tr>
          </thead>
          <tbody class="h-full w-full">
            <tr
              v-if="products.length > 0"
              v-for="product in products"
              :key="product.id"
              class="border-b bg-white hover:bg-gray-100"
            >
              <td class="px-4 py-3">{{ product.code }}</td>
              <td class="px-4 py-3 font-semibold">{{ product.name }}</td>
              <td class="px-4 py-3 text-right">
                S/.
                {{ product.price }}
              </td>
              <td class="px-4 py-3 text-right">S/. {{ product.cost }}</td>
              <td class="px-4 py-3 text-center">
                <div class="dropdown font-semibold">
                  <button
                    class="dropdown-toggle m-0"
                    type="button"
                    id="dropdownMenuButton"
                    data-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false"
                  >
                    Acciones
                  </button>
                  <!-- <div
                    class="dropdown-menu"
                    aria-labelledby="dropdownMenuButton"
                    style=""
                  >
                    <router-link
                      class="dropdown-item"
                      :to="{
                        name: 'edit-product',
                        params: { id: product.id },
                      }"
                    >
                      <i class="col-1 fas fa-edit mr-3"></i>
                      Editar
                    </router-link>
                  </div> -->
                </div>
              </td>
            </tr>
            <!-- <tr v-else-if="!firstLoad">
              <td
                class="px-2 py-2 text-center text-lg font-semibold"
                colspan="8"
              >
                <span> <i class="fas fa-exclamation-triangle"></i></span> No se
                encontraron productos
              </td>
            </tr> -->
            <tr v-else>
              <td
                class="px-2 py-2 text-center text-lg font-semibold"
                colspan="8"
              ></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script setup>
import { onMounted, ref } from "vue";
import NewProduct from "./components/NewProduct.vue";
import Modal from "../../components/modal/Modal.vue";
import { Popover, PopoverButton, PopoverPanel } from "@headlessui/vue";
import { useApiStore } from "@/stores/Api";
const apiStore = useApiStore();

const openModal = ref(false);
const hideButton = ref(false);
const elementHeight = ref(0);

const perPage = ref(10);
const meta = ref(null);
const filters = ref([
  { name: "category", selected: false, values: [] },
  { name: "brand", selected: false, values: [] },
  { name: "supplier", selected: false, values: [] },
  { name: "price", selected: false, values: [0, 0] }, // [min, max]
]);
const selectedFilters = ref([]);
const search = ref("");

const categories = ref([]);
const brands = ref([]);
const suppliers = ref([]);
const products = ref([]);

const fetchData = async () => {
  try {
    const productData = await apiStore.getProducts();
    meta.value = productData[0];
    products.value = productData[1];
    categories.value = await apiStore.getCategories();
    brands.value = await apiStore.getBrands();
    suppliers.value = await apiStore.getSuppliers();
  } catch (error) {
    //alert(error.message);
  }
};

onMounted(() => {
  elementHeight.value = document.getElementById("product_filters").offsetHeight;
});
onMounted(async () => {
  await fetchData();
});
</script>

<style></style>
