<template>
  <div class="relative z-10 flex h-full flex-col">
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

    <!-- FILTERS -->
    <div
      id="product_filters"
      class="flex w-full flex-col justify-evenly gap-4 rounded-tr-xl bg-white p-4 transition-all duration-300"
      :style="{ 'margin-top': hideButton ? `-${elementHeight}px` : '0' }"
    >
      <div class="flex gap-4">
        <SlideMenu
          label="Category"
          class="flex-grow-[2]"
          :state="categoryNames"
        >
          <template #menu-content>
            <div
              class="flex border-b border-gray-300 px-3 py-2 text-base font-bold"
            >
              Categories
            </div>
            <div class="flex flex-col">
              <div
                v-for="category in categories"
                :key="category.id"
                class="flex cursor-pointer items-center justify-start p-2 hover:bg-gray-100"
                @click="toggleCategory(category)"
              >
                <input
                  class="mr-3 h-4 w-4 cursor-pointer accent-cyan-600"
                  type="checkbox"
                  v-model="filters.category.values"
                  :value="category.id"
                />
                <div class="font-semibold">{{ category.name }}</div>
                <div class="mb-[2px] ml-auto text-sm text-gray-500">
                  ({{ category.products_count }})
                </div>
              </div>
            </div>
          </template>
        </SlideMenu>
        <SlideMenu label="Brand" class="flex-grow-[2]" :state="brandNames">
          <template #menu-content>
            <div
              class="flex border-b border-gray-300 px-3 py-2 text-base font-bold"
            >
              Brands
            </div>
            <div class="flex flex-col">
              <div
                v-for="brand in brands"
                :key="brand.id"
                class="flex cursor-pointer items-center justify-start p-2 hover:bg-gray-100"
                @click="toggleBrand(brand)"
              >
                <input
                  class="mr-3 h-4 w-4 cursor-pointer accent-cyan-600"
                  type="checkbox"
                  v-model="filters.brand.values"
                  :value="brand.id"
                />
                <div class="font-semibold">{{ brand.name }}</div>
                <div class="mb-[2px] ml-auto text-sm text-gray-500">
                  ({{ brand.products_count }})
                </div>
              </div>
            </div>
          </template>
        </SlideMenu>
        <button
          class="flex-grow rounded-md bg-gray-800 p-3 font-semibold text-white"
          @click="applyFilters"
        >
          Apply Filters
        </button>
      </div>
      <div class="flex gap-4">
        <SlideMenu label="Supplier" class="flex-grow" :state="supplierNames">
          <template #menu-content>
            <div
              class="flex border-b border-gray-300 px-3 py-2 text-base font-bold"
            >
              Suppliers
            </div>
            <div class="flex flex-col">
              <div
                v-for="supplier in suppliers"
                :key="supplier.id"
                class="flex cursor-pointer items-center justify-start p-2 hover:bg-gray-100"
                @click="toggleSupplier(supplier)"
              >
                <input
                  class="mr-3 h-4 w-4 cursor-pointer accent-cyan-600"
                  type="checkbox"
                  v-model="filters.supplier.values"
                  :value="supplier.id"
                />
                <div class="font-semibold">{{ supplier.name }}</div>
                <div class="mb-[2px] ml-auto text-sm text-gray-500">
                  ({{ supplier.products_count }})
                </div>
              </div>
            </div>
          </template>
        </SlideMenu>
        <SlideMenu class="flex-grow" label="Price" :state="priceRange">
          <template #menu-content>
            <!-- <div class="">
                <Chart :mappedPrices="mappedPrices"></Chart>
              </div> -->
            <RangeSlider
              v-model:min-price="filters.price.values.min"
              v-model:max-price="filters.price.values.max"
            ></RangeSlider>
          </template>
        </SlideMenu>
      </div>
    </div>

    <!-- TABLE -->
    <div
      class="rounded-b-xl border-t border-gray-300 bg-white p-4 shadow-md"
      :class="{ 'rounded-tr-xl': hideButton }"
    >
      <!-- Captions and filter chips -->
      <div class="flex flex-col justify-evenly">
        <div class="my-1 flex flex-wrap">
          <span
            class="mr-2 mt-2 flex items-center py-1 text-xs font-semibold text-blue-800"
          >
            Active filters:
          </span>
          <div
            v-if="selectedFilters.length > 0"
            v-for="(filter, index) in selectedFilters"
            :key="index"
            class="mr-2 mt-2 flex items-center rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-800"
          >
            <span>{{ filter.name }}</span>
            <button
              @click="removeFilter(filter)"
              class="ml-2 focus:outline-none"
            >
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
            <span>No filters applied</span>
          </div>
        </div>
        <div class="my-2 flex items-end justify-between">
          <div class="flex items-center">
            <span class="mr-2 text-sm">Show:</span>
            <select
              v-model="perPage"
              id="entries"
              class="block w-full rounded-lg border-gray-300 bg-gray-50 p-2 py-1 text-sm outline outline-1 outline-gray-300 focus:outline-2 focus:outline-cyan-500"
            >
              <option value="5">5</option>
              <option value="10" selected>10</option>
              <option value="15">15</option>
              <option value="20">20</option>
            </select>
            <span class="ml-2 text-sm">rows</span>
          </div>
          <div class="mr-1">
            <div class="flex w-full">
              <input
                v-model="search"
                name="table_search"
                type="search"
                class="block w-full rounded-l-lg border border-gray-300 bg-gray-50 p-2.5 text-sm outline-gray-300 focus:border-2 focus:border-cyan-500 focus:outline-none"
                placeholder="Buscar producto"
                autocomplete="off"
              />
              <!--Search button-->
              <button
                class="flex items-center rounded-l-none rounded-r-md border border-l-0 border-gray-300 bg-gray-200 p-2.5 text-sm text-white hover:bg-gray-300"
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
            <tr v-if="apiStore.productLoading">
              <td class="px-2 py-1 text-center text-2xl" colspan="5">
                Searching...
                <span
                  class="spinner-border text-danger mr-2"
                  role="status"
                  style="font-size: 0.8rem"
                >
                </span>
              </td>
            </tr>
            <tr
              v-else-if="products.length > 0"
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
            <tr v-else>
              <td class="px-2 py-1 text-center text-2xl" colspan=" 5">
                <i class="fas fa-exclamation-triangle mr-2 text-2xl"></i>
                No products found
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      <div class="mt-5 flex items-center justify-between">
        <span class="text-sm" v-if="meta?.from && meta?.to"
          >Showing {{ meta.from }} to {{ meta.to }} of
          {{ meta.total }} products</span
        >
        <nav>
          <ul class="mr-10 inline-flex -space-x-px text-sm text-gray-500">
            <li
              v-if="meta?.links?.length > 0"
              v-for="(link, index) in meta.links"
              :key="link.index"
              :class="
                link.url == null
                  ? 'page-item disabled'
                  : link.active
                    ? 'page-item active'
                    : 'page-item'
              "
            >
              <button
                class="ms-0 flex h-8 items-center justify-center border border-gray-300 px-3 leading-tight"
                :class="[
                  {
                    disabled: link.url == null,
                    'bg-cyan-100 text-cyan-600': link.active,
                    'bg-white hover:bg-gray-100 hover:text-gray-700':
                      !link.active && link.url != null,
                    'rounded-l-md': index == 0,
                    'pointer-events-none rounded-l-md':
                      (index == 0 || index == meta.links.length - 1) &&
                      link.url == null,
                    'rounded-r-md': index == meta.links.length - 1,
                  },
                ]"
                @click.prevent="
                  link.url == null || link.active
                    ? null
                    : fetchProductData(link.url)
                "
              >
                {{
                  index == 0
                    ? "Prev"
                    : index == meta.links.length - 1
                      ? "Next"
                      : link.label
                }}
              </button>
            </li>
          </ul>
        </nav>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed, onMounted, ref, watch } from "vue";
import NewProduct from "./components/NewProduct.vue";
import Modal from "../../components/modal/Modal.vue";
import SlideMenu from "../../components/slidemenu/SlideMenu.vue";
import RangeSlider from "./components/RangeSlider.vue";
import { useApiStore } from "@/stores/Api";
import Chart from "./components/Chart.vue";
const apiStore = useApiStore();

const openModal = ref(false);
const hideButton = ref(false);
const elementHeight = ref(0);

const perPage = ref(10);
const meta = ref(null);
const filters = ref({
  category: {
    name: "Category", // used in chips
    id: 1,
    selected: false,
    values: [],
  },
  brand: {
    name: "Brand", // used in chips
    id: 2,
    selected: false,
    values: [],
  },
  supplier: {
    name: "Supplier", // used in chips
    id: 3,
    selected: false,
    values: [],
  },
  price: {
    name: "Price",
    id: 4,
    selected: false,
    values: {
      min: 0,
      max: 0,
    },
  },
});
const selectedFilters = computed(() => {
  return Object.values(filters.value).filter((filter) => {
    return filter.selected;
  });
});
const removeFilter = (filter) => {
  if (filter.name === "Brand") {
    filters.value.brand.values.splice(0, filters.value.brand.values.length);
  } else if (filter.name === "Category") {
    filters.value.category.values.splice(
      0,
      filters.value.category.values.length,
    );
  } else if (filter.name === "Price") {
    filters.value.price.values.min = 0;
    filters.value.price.values.max = 0;
  } else if (filter.name === "Supplier") {
    filters.value.supplier.values.splice(
      0,
      filters.value.supplier.values.length,
    );
  }
  applyFilters();
};
const applyFilters = async () => {
  const filterKeys = Object.keys(filters.value);

  filterKeys.forEach((key) => {
    const filter = filters.value[key];

    if (key === "brand" || key === "category" || key === "supplier") {
      filter.selected = filter.values.length > 0;
    } else if (key === "price") {
      filter.selected = filter.values.min !== 0 || filter.values.max !== 0;
    }
  });
  fetchProductData();
};
const categoryNames = computed(() => {
  let names = "";
  let count = 0;
  filters.value.category.values.forEach((id) => {
    const category = categories.value.find((category) => category.id === id);
    if (category) {
      if (count === 0) {
        names += category.name;
      } else if (count < 3) {
        names += ", " + category.name;
      }
      count++;
    }
  });
  if (count > 3) {
    return `( ${names}, +${count - 3} )`;
  }
  if (names === "") return "";
  return `( ${names} )`;
});
const brandNames = computed(() => {
  let names = "";
  let count = 0;
  filters.value.brand.values.forEach((id) => {
    const brand = brands.value.find((brand) => brand.id === id);
    if (brand) {
      if (count === 0) {
        names += brand.name;
      } else if (count < 3) {
        names += ", " + brand.name;
      }
      count++;
    }
  });
  if (count > 3) {
    return `( ${names}, +${count - 3} )`;
  }
  if (names === "") return "";
  return `( ${names} )`;
});
const supplierNames = computed(() => {
  let names = "";
  let count = 0;
  filters.value.supplier.values.forEach((id) => {
    const supplier = suppliers.value.find((supplier) => supplier.id === id);
    if (supplier) {
      if (count === 0) {
        names += supplier.name;
      } else if (count < 3) {
        names += ", " + supplier.name;
      }
      count++;
    }
  });
  if (count > 3) {
    return `( ${names}, +${count - 3} )`;
  }
  if (names === "") return "";
  return `( ${names} )`;
});
const priceRange = computed(() => {
  if (
    filters.value.price.values.min !== 0 ||
    filters.value.price.values.max !== 0
  ) {
    return `( S/. ${filters.value.price.values.min} - ${filters.value.price.values.max} )`;
  }
  return "";
});
const search = ref("");
const searchTimeout = ref(null);
const productsNotFound = ref(false);

const categories = ref([]);
const brands = ref([]);
const suppliers = ref([]);
const products = ref([]);

const mappedPrices = ref([]);

const fetchEntitiesData = async () => {
  try {
    let response = await apiStore.getDataForFilters();
    categories.value = response[0];
    brands.value = response[1];
    suppliers.value = response[2];
    mappedPrices.value = response[3];
  } catch (error) {
    //alert(error.message);
  }
};

const fetchProductData = async (link = null) => {
  let page = 1;
  try {
    if (link) {
      let currentPage = new URL(link).searchParams.get("page");
      page = currentPage;
    }
    const productData = await apiStore.getProducts(
      page,
      perPage.value,
      search.value,
      selectedFilters.value,
    );
    meta.value = productData[0];
    products.value = productData[1];

    productsNotFound.value = products.value.length > 0 ? false : true;
  } catch (error) {
    // alert(error.message);
  }
};
const toggleCategory = (category) => {
  const index = filters.value.category.values.indexOf(category.id);
  if (index === -1) {
    filters.value.category.values.push(category.id);
  } else {
    filters.value.category.values.splice(index, 1);
  }
};
const toggleBrand = (brand) => {
  const index = filters.value.brand.values.indexOf(brand.id);
  if (index === -1) {
    filters.value.brand.values.push(brand.id);
  } else {
    filters.value.brand.values.splice(index, 1);
  }
};
const toggleSupplier = (supplier) => {
  const index = filters.value.supplier.values.indexOf(supplier.id);
  if (index === -1) {
    filters.value.supplier.values.push(supplier.id);
  } else {
    filters.value.supplier.values.splice(index, 1);
  }
};
fetchProductData();
fetchEntitiesData();

onMounted(() => {
  elementHeight.value = document.getElementById("product_filters").offsetHeight;
});

watch(
  [search, perPage],
  async ([newSearch, newPerPage], [oldSearch, oldPerPage]) => {
    if (newPerPage !== oldPerPage) {
      await fetchProductData();
    } else if (newSearch !== oldSearch) {
      clearTimeout(searchTimeout.value);
      if (newSearch === "") {
        await fetchProductData();
      } else {
        searchTimeout.value = setTimeout(async () => {
          await fetchProductData();
        }, 400);
      }
    }
  },
);
</script>

<style></style>
