<template>
  <div class="flex flex-col gap-4">
    <Title>{{ title }}</Title>
    <Header>
      {{ header }}
    </Header>
    <Paragraph class="max-w-[650px]">
      {{ description }}
    </Paragraph>
  </div>
</template>

<script setup>
import Header from "./Header.vue";
import Title from "./Title.vue";
import Paragraph from "./Paragraph.vue";
defineProps({
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
