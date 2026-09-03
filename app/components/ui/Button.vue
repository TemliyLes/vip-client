<template>
  <a
    href="#"
    :class="isFit"
    class="inline-flex items-center justify-center gap-6 bg-wine px-8 py-4 text-sm uppercase tracking-[0.15em] text-white transition duration-300 hover:bg-[#9e0012]"
  >
    <span class="flex gap-3"> <slot /> <Arrow v-if="arrow" /></span>
  </a>
</template>

<script setup>
import Arrow from "../icons/arrow.vue";
const props = defineProps({
  fit: {
    type: Boolean,
    default: false,
  },
  arrow: {
    type: Boolean,
    default: false,
  },
});
const isFit = computed(() => (!props.fit ? "w-fit" : "w-full"));
</script>
