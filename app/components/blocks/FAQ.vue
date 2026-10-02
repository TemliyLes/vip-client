<template>
  <div class="mt-12 sm:mt-24">
    <Container>
      <div class="flex flex-col gap-4 items-center">
        <Title>{{ $t('ui.components.blocks.FAQ.titleText1') }}</Title>
        <Header class="text-center">{{ $t('ui.components.blocks.FAQ.headerText1') }}</Header>
        <Paragraph class="text-center">{{ $t('ui.components.blocks.FAQ.paragraphText1') }}</Paragraph>
      </div>
      <Faq :data="store.all"></Faq>
    </Container>
  </div>
</template>

<script setup>
import Header from "../ui/Header.vue";
import Title from "../ui/Title.vue";
import Paragraph from "../ui/Paragraph.vue";
import Container from "../ui/Container.vue";
import { useFaqStore } from "~/store/faq.js";
import Faq from "../ui/Faq.vue";
const store = useFaqStore();

onMounted(() => {
  store?.getFaq();
});
</script>
