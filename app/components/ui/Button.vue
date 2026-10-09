<template>
  <component
    :is="element"
    :href="link || undefined"
    :type="element === 'button' ? type : undefined"
    :disabled="element === 'button' ? disabled : undefined"
    :class="isFit"
    class="cursor-pointer inline-flex items-center justify-center gap-6 bg-wine px-8 py-4 text-sm uppercase tracking-[0.15em] text-white transition duration-300 hover:bg-[#9e0012] disabled:cursor-wait disabled:opacity-60"
    @click="handleClick"
  >
    <span class="flex gap-3"> <slot /> <Arrow v-if="arrow" /></span>
  </component>
</template>

<script setup>
import Arrow from "../icons/arrow.vue";
const props = defineProps({
  tag: {
    type: String,
  },
  fit: {
    type: Boolean,
    default: false,
  },
  arrow: {
    type: Boolean,
    default: false,
  },
  to: {
    type: String,
  },
  type: { type: String, default: "button" },
  disabled: { type: Boolean, default: false },
  // Custom actions can opt out; submit buttons and decorative spans never open a form.
  form: { type: Boolean, default: true },
});
const emit = defineEmits(["click"]);
const { open } = useFeedbackModal();
const link = computed(() => props.to?.trim() || "");
const element = computed(() => props.tag || (link.value ? "a" : "button"));
const handleClick = (event) => {
  if (props.disabled) {
    event.preventDefault();
    return;
  }
  emit("click", event);
  // @click.prevent also lets a caller replace the default action.
  if (!event.defaultPrevented && !link.value && element.value === "button" &&
      props.type === "button" && props.form) {
    open();
  }
};
const isFit = computed(() => (!props.fit ? "w-fit" : "w-full"));
</script>
