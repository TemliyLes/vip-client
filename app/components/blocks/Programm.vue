<template>
  <Container tag="section" class="py-12 sm:py-24">
    <header class="flex justify-between items-center">
      <div class="flex flex-col gap-4">
        <Title>{{ $t('ui.components.blocks.Programm.titleText1') }}</Title>
        <Header>{{ $t('ui.components.blocks.Programm.headerText1') }}<br />{{ $t('ui.components.blocks.Programm.headerText2') }}</Header>
        <Paragraph class="max-w-[650px]">{{ $t('ui.components.blocks.Programm.paragraphText1') }}<br />{{ $t('ui.components.blocks.Programm.paragraphText2') }}</Paragraph>
      </div>
      <img
        class="h-36 mr-6 mt-4 hidden sm:block"
        src="../../assets/img/styletext2.png"
        alt=""
      />
    </header>
    <ul class="grid sm:grid-cols-3 grid-cols-1 gap-3 mt-6">
      <li v-for="item in data" :key="item.id" class="flex min-w-0 flex-col">
        <Card :data="item" />
      </li>
    </ul>
  </Container>
</template>

<script setup>
import Card from "../cards/Card.vue";
import Container from "../ui/Container.vue";
import Title from "../ui/Title.vue";
import Header from "../ui/Header.vue";
import Paragraph from "../ui/Paragraph.vue";
const api = useWpApi();
const { locale } = useI18n({ useScope: "global" });
const { data } = await useAsyncData(`program:${locale.value}`, () => api.servicesByCategory(45));
</script>
