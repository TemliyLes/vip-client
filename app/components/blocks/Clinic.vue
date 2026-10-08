<template>
  <div class="py-10">
    <Container class="relative">
      <div
        class="flex flex-col sm:w-1/2 sm:justify-end gap-4 absolute right-0 h-full z-9 sm:p-24 p-12 justify-between"
      >
        <Tag>{{ $t('ui.components.blocks.Clinic.tagText1') }}</Tag>
        <Header>
          <span class="!text-white whitespace-pre-line">{{ store?.page?.about?.intro?.title?.raw?.replace(/\r\n?/g, "\n") }}</span>
        </Header>
        <Paragraph tag="div" class="!text-white">
          <div
            v-html="store?.page?.about?.intro?.subtitle?.rendered"
          />
        </Paragraph>
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
import Tag from "../ui/Tag.vue";
import Header from "../ui/Header.vue";
const store = usePageStore();
const { locale } = useI18n({ useScope: "global" });
await callOnce(`page:125:${locale.value}`, () => store.fetchPage(125), { mode: "navigation" });
</script>
