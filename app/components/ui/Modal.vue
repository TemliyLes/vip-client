<template>
  <Teleport v-if="mounted" :to="teleports">
    <Transition
      enter-active-class="transition duration-300 ease-out"
      enter-from-class="opacity-0"
      enter-to-class="opacity-100"
      leave-active-class="transition duration-200 ease-in"
      leave-from-class="opacity-100"
      leave-to-class="opacity-0"
    >
      <div
        v-if="modelValue"
        class="fixed inset-0 z-[1000] flex items-center justify-center p-4 sm:p-8"
        @click.self="close"
      >
        <!-- Overlay -->
        <div
          class="absolute inset-0 bg-black/50 backdrop-blur-[2px]"
          @click="close"
        />

        <!-- Modal -->
        <Transition
          enter-active-class="transition duration-300 ease-out"
          enter-from-class="opacity-0 translate-y-5 scale-95"
          enter-to-class="opacity-100 translate-y-0 scale-100"
          leave-active-class="transition duration-200 ease-in"
          leave-from-class="opacity-100 translate-y-0 scale-100"
          leave-to-class="opacity-0 translate-y-5 scale-95"
        >
          <div
            v-if="modelValue"
            class="relative z-10 w-full max-w-[700px] max-h-[90vh] overflow-y-auto bg-white"
            role="dialog"
            aria-modal="true"
            @click.stop
          >
            <!-- Close -->
            <button
              type="button"
              class="cursor-pointer absolute top-4 right-4 z-20 w-10 h-10 flex items-center justify-center transition duration-300 hover:bg-gray-100"
              aria-label="Zavřít"
              @click="close"
            >
              <svg
                width="22"
                height="22"
                viewBox="0 0 24 24"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  d="M6 6L18 18M18 6L6 18"
                  stroke="currentColor"
                  stroke-width="1.5"
                  stroke-linecap="round"
                />
              </svg>
            </button>

            <!-- Content -->
            <div class="p-6 sm:p-10">
              <slot />
            </div>
          </div>
        </Transition>
      </div>
    </Transition>
  </Teleport>
</template>

<script setup>
import { onMounted, onBeforeUnmount, ref, watch } from "vue";

const props = defineProps({
  modelValue: {
    type: Boolean,
    default: false,
  },

  teleports: {
    type: String,
    default: "#modal",
  },
});

const emit = defineEmits(["update:modelValue", "close"]);

const mounted = ref(false);

const close = () => {
  emit("update:modelValue", false);
  emit("close");
};

const handleKeydown = (event) => {
  if (event.key === "Escape" && props.modelValue) {
    close();
  }
};

const toggleScroll = (state) => {
  if (!import.meta.client) return;

  document.body.style.overflow = state ? "hidden" : "";
};

watch(
  () => props.modelValue,
  (value) => {
    toggleScroll(value);
  },
);

onMounted(() => {
  mounted.value = true;

  window.addEventListener("keydown", handleKeydown);

  if (props.modelValue) {
    toggleScroll(true);
  }
});

onBeforeUnmount(() => {
  window.removeEventListener("keydown", handleKeydown);

  toggleScroll(false);
});
</script>
