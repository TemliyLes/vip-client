<template>
  <p
    class="grid place-item-center border bodred-1 border-white w-fit px-4 py-2"
  >
    <Paragraph tag="span" class="block !text-white uppercase"><slot /></Paragraph>
  </p>
</template>

<script setup>
import Paragraph from "./Paragraph.vue";
</script>
