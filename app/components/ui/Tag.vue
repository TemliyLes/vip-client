<template>
  <div
    class="grid place-item-center border bodred-1 border-white w-fit px-4 py-2"
  >
    <Paragraph class="!text-white uppercase"><slot /></Paragraph>
  </div>
</template>

<script setup>
import Paragraph from "./Paragraph.vue";
</script>
