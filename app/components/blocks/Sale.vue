<template>
  <div class="mt-12 sm:mt-24">
    <Container>
      <div class="flex flex-col gap-4 items-center">
        <Title>{{ $t('ui.components.blocks.Sale.titleText1') }}</Title>
        <Header class="text-center"
          >{{ $t('ui.components.blocks.Sale.headerText1') }}<br />{{ $t('ui.components.blocks.Sale.headerText2') }}</Header
        >
        <Paragraph class="text-center"
          >{{ $t('ui.components.blocks.Sale.paragraphText1') }}<br />{{ $t('ui.components.blocks.Sale.paragraphText2') }}</Paragraph
        >
      </div>

      <div class="grid sm:grid-cols-4 grid-cols-1 gap-3 mt-6">
        <div v-for="item in data" :key="item.id">
          <Card desc :data="item" />
        </div>
      </div>
    </Container>
  </div>
</template>

<script setup>
import Header from "../ui/Header.vue";
import Container from "../ui/Container.vue";
import Title from "../ui/Title.vue";
import Paragraph from "../ui/Paragraph.vue";
import { useServicesStore } from "~/store/services.js";
import Card from "../cards/Card.vue";

const store = useServicesStore();
const data = ref(null);
onMounted(async () => {
  data.value = await store?.getServiceByCategory(47);
});
</script>
