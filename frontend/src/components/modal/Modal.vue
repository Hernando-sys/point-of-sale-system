<template>
  <div class="hidden">
    <TransitionRoot
      :show="isOpen"
      as="template"
      enter="duration-300 ease-in"
      enter-from="opacity-0"
      enter-to="opacity-100"
      leave="duration-200 ease-out"
      leave-from="opacity-100"
      leave-to="opacity-0"
      :unmount="false"
    >
      <Dialog
        as="div"
        @close="$emit('modalClosed')"
        :unmount="false"
        class="relative z-10"
      >
        <div class="fixed inset-0 bg-black/30" aria-hidden="true" />

        <div class="fixed inset-0 overflow-y-auto">
          <div
            class="flex min-h-full items-center justify-center p-4 text-center"
          >
            <DialogPanel
              class="w-full max-w-md transform overflow-hidden rounded-2xl bg-white p-6 text-left align-middle shadow-xl transition-all"
            >
              <DialogTitle
                as="h3"
                class="text-lg font-medium leading-6 text-gray-900"
              >
                <slot name="modal-title"></slot>
              </DialogTitle>
              <slot name="modal-content"></slot>

              <div class="mt-4 flex justify-end">
                <button
                  type="button"
                  class="inline-flex justify-center rounded-md border border-transparent bg-blue-100 px-4 py-2 text-sm font-medium text-blue-900 hover:bg-blue-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"
                  @click="$emit('modalClosed')"
                >
                  Got it, thanks!
                </button>
              </div>
            </DialogPanel>
          </div>
        </div>
      </Dialog>
    </TransitionRoot>
  </div>
</template>

<script setup>
import { ref } from "vue";
import {
  Dialog,
  DialogPanel,
  DialogTitle,
  TransitionRoot,
  TransitionChild,
} from "@headlessui/vue";

const props = defineProps({
  isOpen: {
    type: Boolean,
    default: false,
  },
});
</script>

<style></style>
