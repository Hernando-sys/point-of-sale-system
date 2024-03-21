<template>
  <div>
    <div class="text-muted mb-6 cursor-pointer self-end text-right text-sm">
      <button @click="reset">Reiniciar</button>
    </div>
    <div class="flex items-center justify-center">
      <div class="flex w-full flex-col">
        <div class="relative">
          <input
            ref="fromSlider"
            id="fromSliderZ"
            class="mt-[2px] appearance-none"
            type="range"
            v-model="minPriceSlider"
            :min="miscellaneousStore.minValue"
            :max="miscellaneousStore.maxValue"
            :step="5"
          />
          <input
            ref="toSlider"
            id="toSliderZ"
            v-model="maxPriceSlider"
            type="range"
            class="appearance-none"
            :class="{ 'z-[20]': maxPrice <= minThreshold }"
            :min="miscellaneousStore.minValue"
            :max="miscellaneousStore.maxValue"
            :step="5"
          />
        </div>
        <div class="mt-10  flex items-center justify-between gap-8">
          <span class="font-semibold" for="fromSliderZ">Precio min:</span>
          <div class="flex items-center justify-end gap-2">
            <span>S/.</span>

            <input
              type="number"
              class="w-[100px] border px-2 py-1"
              :value="minPriceInput"
              @input="updateMinPriceFromInput($event.target.value)"
              :min="miscellaneousStore.minValue"
              :max="miscellaneousStore.maxValue"
              :step="miscellaneousStore.intervalWidth"
            />
          </div>
        </div>
        <div class="mt-4 flex items-center justify-between gap-8">
          <span class="font-semibold" for="toSlider">Precio max:</span>
          <div class="flex items-center justify-end gap-2">
            <span>S/.</span>
            <input
              type="number"
              class="w-[100px] border px-2 py-1"
              :value="maxPriceInput"
              @input="updateMaxPriceFromInput($event.target.value)"
              :min="miscellaneousStore.minValue"
              :max="miscellaneousStore.maxValue"
              :step="miscellaneousStore.intervalWidth"
            />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, watch } from "vue";
import { useMiscellaneousStore } from "@/stores/Miscellaneous";
const miscellaneousStore = useMiscellaneousStore();
const props = defineProps({
  minPrice: {
    type: [Number, String],
  },
  maxPrice: {
    type: [Number, String],
  },
  itsTimeToReset: {
    type: Boolean,
    default: false,
  },
});
const emits = defineEmits([
  "update:minPrice",
  "update:maxPrice",
  "price-resetted",
]);

const minThreshold = ref(0);
const minPriceSlider = ref(0);
const maxPriceSlider = ref(0);

const minPriceInput = ref(0);
const maxPriceInput = ref(0);

const toSlider = ref(null);
const fromSlider = ref(null);

const fillSlider = () => {
  let rangeColor = "#0891b2";
  let sliderColor = "#C6C6C6";
  const rangeDistance = toSlider.value.max - toSlider.value.min;
  const fromPosition = parseInt(props.minPrice) - toSlider.value.min;
  const toPosition = parseInt(props.maxPrice) - toSlider.value.min;

  toSlider.value.style.background = `linear-gradient(
    to right,
    ${sliderColor} 0%,
    ${sliderColor} ${(fromPosition / rangeDistance) * 100}%,
    ${rangeColor} ${(fromPosition / rangeDistance) * 100}%,
    ${rangeColor} ${(toPosition / rangeDistance) * 100}%,
    ${sliderColor} ${(toPosition / rangeDistance) * 100}%,
    ${sliderColor} 100%)`;
};
const reset = () => {
  minPriceSlider.value = 0;
  maxPriceSlider.value = 0;
};
const updateMinPriceFromInput = (value) => {
  if (value === "") return;
  minPriceInput.value = value;
  if (value > props.maxPrice) {
    return;
  }
  minPriceSlider.value = value;
};
const updateMaxPriceFromInput = (value) => {
  if (value === "") return;
  maxPriceInput.value = value;
  if (value < props.minPrice) {
    return;
  }
  maxPriceSlider.value = value;
};

watch(
  () => miscellaneousStore.maxValue,
  () => {
    minThreshold.value = parseInt(miscellaneousStore.maxValue) * 0.03;
  },
);

watch(minPriceSlider, (newValue, oldValue) => {
  newValue = parseInt(newValue);
  oldValue = parseInt(oldValue);
  let lowerBound = parseInt(miscellaneousStore.minValue);
  let upperBound = parseInt(props.maxPrice);

  if (newValue > upperBound || newValue < lowerBound) {
    minPriceSlider.value = oldValue;
    emits("update:minPrice", oldValue);
  } else {
    emits("update:minPrice", newValue);
    fillSlider();
  }
});

watch(maxPriceSlider, (newValue, oldValue) => {
  newValue = parseInt(newValue);
  oldValue = parseInt(oldValue);
  let lowerBound = parseInt(props.minPrice);
  if ((newValue) < (lowerBound)) {
    maxPriceSlider.value = oldValue;
    emits("update:maxPrice", oldValue);
  } else {
    emits("update:maxPrice", newValue);
    fillSlider();
  }
});

watch(
  () => props.minPrice,
  (newValue) => {
    minPriceInput.value = newValue;
    fillSlider();
  },
);
watch(
  () => props.maxPrice,
  (newValue) => {
    maxPriceInput.value = newValue;
    fillSlider();
  },
);
</script>

<style>
input[type="range"]::-webkit-slider-thumb {
  pointer-events: all;
  width: 12px;
  height: 12px;
  border-radius: 50%;
  box-shadow: 0 0 0 1px #c6c6c6;
  cursor: pointer;
}

input[type="range"]::-moz-range-thumb {
  -webkit-appearance: none;
  pointer-events: all;
  width: 12px;
  height: 12px;
  background-color: #fff;
  border-radius: 50%;
  box-shadow: 0 0 0 1px #c6c6c6;
  cursor: pointer;
}

input[type="range"]::-webkit-slider-thumb:active {
  box-shadow:
    inset 0 0 3px #c3c3c3,
    0 0 9px #c3c3c3;
  -webkit-box-shadow:
    inset 0 0 3px #c3c3c3,
    0 0 9px #c3c3c3;
}

input[type="range"] {
  -webkit-appearance: none;
  height: 4px;
  width: 100%;
  position: absolute;
  background-color: #c6c6c6;
  pointer-events: none;
}
input#fromSliderZ::-webkit-slider-thumb {
  -webkit-appearance: none;
  height: 14px;
  width: 14px;
  background-color: #e2e2e2;
}

input#toSliderZ::-webkit-slider-thumb {
  -webkit-appearance: none;
  height: 14px;
  width: 14px;
  background-color: #979797;
}

#fromSliderZ {
  height: 0;
  z-index: 10;
}
</style>
