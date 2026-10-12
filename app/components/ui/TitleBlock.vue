<template>
  <header class="flex flex-col gap-4">
    <Title>{{ title }}</Title>
    <Header :tag="headingTag">
      {{ header }}
    </Header>
    <Paragraph class="max-w-[650px]">
      {{ description }}
    </Paragraph>
  </header>
</template>

<script setup>
import Header from "./Header.vue";
import Title from "./Title.vue";
import Paragraph from "./Paragraph.vue";
defineProps({
  headingTag: { type: String, default: "h2" },
  title: {
    type: String,
  },
  header: {
    type: String,
  },
  description: {
    type: String,
  },
});
</script>
