<template>
  <div :style="[randomStyle(), ranBg()]">
    Lorem ipsum dolor sit amet consectetur adipisicing elit. Architecto
    similique perspiciatis odio fuga molestiae quaerat quasi sapiente nostrum
    laudantium rem, nulla corporis ad aliquid magnam? Corporis eius non tempora
    libero.
  </div>
</template>

<script setup>
const randomStyle = () => `height: ${Math.floor(Math.random() * 400) + 400}px`;
const ranBg = () =>
  `background: ${"#" + Math.floor(Math.random() * 16777215).toString(16)}`;
</script>
