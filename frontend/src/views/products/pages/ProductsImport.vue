<template>
  <div class="flex h-full flex-col gap-4">
    <div class="mb-2 flex items-center">
      <a
        href="#"
        @click="goBack"
        class="border- mr-2.5 flex items-center justify-center rounded-[50%] bg-gray-500 hover:bg-gray-400 text-white p-2"
      >
        <span class="material-icons text-md">arrow_back</span>
      </a>
      <h1 class="flex items-end text-3xl font-bold">Import Data from Excel</h1>
    </div>

    <div class="flex flex-col gap-4 rounded-xl bg-white p-4 shadow-md">
      <!-- Progress Indicator -->
      <div class="flex items-center justify-center text-sm">
        <div
          v-for="(step, index) in totalSteps"
          :key="step"
          class="mb-5 flex items-center justify-center"
        >
          <div class="relative flex flex-col items-center justify-center">
            <div
              class="circle step border-2"
              :class="{
                'border-2 border-cyan-600 bg-cyan-600': currentStep > step,
                'active-circle': currentStep === step,
              }"
            >
              <div v-if="currentStep > step" class="text2xl text-white">
                &#10003;
              </div>
              <div
                v-else
                class="text-gray-400 text-lg"
                :class="{
                  'active-circle  border-cyan-600': currentStep === step,
                }"
              >
                {{ step }}
              </div>
            </div>
            <small class="absolute top-[100%] w-[70px] text-center">
              {{ stepsLabel[index] }}
            </small>
          </div>
          <div v-if="step != 3" class="step">
            <div
              class="line"
              :class="{
                'border-cyan-600 bg-cyan-600': currentStep > step,
                'border-gray-300 bg-gray-300': currentStep <= step,
              }"
            ></div>
          </div>
        </div>
      </div>

      <!-- Navigation Buttons -->
      <div class="flex justify-end gap-4">
        <button
          v-if="currentStep !== 1"
          @click="prevStep"
          class="rounded-md bg-gray-500 px-4 py-2 font-semibold text-white hover:bg-gray-400"
        >
          Anterior
        </button>
        <button
          v-if="currentStep !== totalSteps && currentStep !== 2"
          @click="nextStep"
          class="rounded-md bg-cyan-600 px-4 py-2 font-semibold text-white hover:bg-cyan-500"
        >
          Siguiente
        </button>
        <button
          v-else-if="currentStep === 2"
          @click="nextStep"
          class="rounded-md bg-cyan-600 px-4 py-2 font-semibold text-white hover:bg-cyan-500"
        >
          Importar
        </button>
        <button
          v-else-if="currentStep === 3"
          @click="nextStep"
          class="rounded-md bg-cyan-600 px-4 py-2 font-semibold text-white hover:bg-cyan-500"
        >
          Finalizar
        </button>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from "vue";
const currentStep = ref(1);
const totalSteps = 3;
const stepsLabel = ["Upload File", "Map Columns", "Review & Import"];

const nextStep = () => {
  if (currentStep.value === 1) {
    currentStep.value++;
  } else if (currentStep.value === 2) {
    currentStep.value++;
  } else {
    if (currentStep.value < totalSteps) {
      currentStep.value++;
    }
  }
};
const prevStep = () => {
  if (currentStep.value > 1) {
    currentStep.value--;
  } else if (currentStep.value === 2) {
    currentStep.value--;
  } else {
    currentStep.value--;
  }
};

const goBack = () => {
  window.history.back();
};
</script>

<style scoped>
.step {
  position: relative;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
}

.circle {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  z-index: 1;
}

.line {
  height: 2px;
  width: 140px;
  display: block;
  overflow-x: visible;
  z-index: 0;
}



.active-circle {
  border-color: #0891b2;
  color: #0891b2;
}
</style>
