<template>
  <div class="py-10">
    <Container class="relative">
      <div
        class="flex flex-col w-1/2 justify-end gap-4 absolute right-0 h-full z-9 p-24 p-12"
      >
        <Tag>Prostor</Tag>
        <Header
          ><span
            class="!text-white"
            v-html="store?.page?.about?.intro?.title?.rendered"
          ></span
        ></Header>
        <Paragraph>
          <span
            class="!text-white"
            v-html="store?.page?.about?.intro?.subtitle?.rendered"
          ></span
        ></Paragraph>
      </div>
      <AlterHero dark />
    </Container>
  </div>
</template>

<script setup>
import AlterHero from "./AlterHero.vue";
import Container from "../ui/Container.vue";
import { usePageStore } from "~/store/page.js";
import Paragraph from "../ui/Paragraph.vue";
import Button from "../ui/Button.vue";
import Tag from "../ui/Tag.vue";
import Header from "../ui/Header.vue";
const store = usePageStore();

onMounted(() => {
  store.fetchPage(125);
});
</script>
