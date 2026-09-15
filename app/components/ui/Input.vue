<template>
  <input
    v-if="phone"
    v-maska
    data-maska="+420 ### ### ###"
    :value="modelValue"
    :type="type"
    :placeholder="placeholder"
    class="w-full border border-gray-200 px-4 py-3 outline-none transition duration-300 focus:border-black"
    @input="updateValue"
  />

  <input
    v-else
    :value="modelValue"
    :type="type"
    :placeholder="placeholder"
    class="w-full border border-gray-200 px-4 py-3 outline-none transition duration-300 focus:border-black"
    @input="updateValue"
  />
</template>

<script setup>
import { vMaska } from "maska/vue";

defineProps({
  modelValue: {
    type: String,
    default: "",
  },

  type: {
    type: String,
    default: "text",
  },

  placeholder: {
    type: String,
    default: "",
  },

  phone: {
    type: Boolean,
    default: false,
  },
});

const emit = defineEmits(["update:modelValue"]);

const updateValue = (event) => {
  emit("update:modelValue", event.target.value);
};
</script>
