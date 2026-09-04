<template>
  <component :is="Renderer" />
</template>

<script setup>
import { h } from "vue";

import Paragraph from "./Paragraph.vue";

import Header from "./Header.vue";

const props = defineProps({
  content: {
    type: String,
    default: "",
  },
});

const { renderRichText } = useWpRichText({
  p: Paragraph,
  h2: Header,
  // h3: SubTitle,
  // a: Link,
  // ul: List,
  // li: ListItem,
});

const Renderer = () => {
  return h(
    "div",
    {
      class: "rich-text",
    },
    renderRichText(props.content),
  );
};
</script>
