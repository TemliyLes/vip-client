<template>
  <div :class="alignClass">
    <span :class="abClass" class="text-wine uppercase leading-9"><slot /></span>
  </div>
</template>
<script setup>
const props = defineProps({
  mini: {
    type: Boolean,
    default: false,
  },
  center: {
    type: Boolean,
    default: false,
  },
});
const abClass = computed(() =>
  props.mini ? "text-[15px] font-bold !leading-0" : "text-[32px]",
);
const alignClass = computed(() => (props.center ? "text-center" : ""));
</script>
