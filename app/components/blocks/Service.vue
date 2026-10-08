<template>
  <section ref="section" class="py-12 sm:py-24">
    <Container>
      <div
        class="sm:grid sm:grid-cols-[330px_1fr] flex flex-col gap-3 items-stretch"
      >
        <!-- LEFT CONTENT -->

        <div class="flex h-full flex-col justify-between bg-white">
          <div>
            <Title class="mb-4">{{ $t('ui.components.blocks.Service.titleText1') }}</Title>

            <Header>{{ $t('ui.components.blocks.Service.headerText1') }}<br />{{ $t('ui.components.blocks.Service.headerText2') }}</Header>
            <img src="../../assets/img/styletext.png" width="590" height="178" alt="" />
            <Paragraph class="mt-5 mb-4 max-w-[280px]">{{ $t('ui.components.blocks.Service.paragraphText1') }}</Paragraph>
          </div>

          <Button full>{{ $t('ui.components.blocks.Service.buttonText1') }}</Button>
        </div>

        <!-- CARDS -->

        <div
          class="grid sm:grid-cols-3 grid-cols-1 gap-5 sm:gap-3 mt-6 sm:mt-0"
        >
          <div
            v-for="item in data"
            ref="cards"
            :key="item?.id"
            class="flex flex-col border-l border-white"
          >
            <Card category :data="item" />
          </div>
        </div>
      </div>
    </Container>
  </section>
</template>

<script setup>
import { gsap } from "gsap";

import Container from "../ui/Container.vue";
import Title from "../ui/Title.vue";
import Button from "../ui/Button.vue";
import Header from "../ui/Header.vue";
import Paragraph from "../ui/Paragraph.vue";
import Card from "../cards/Card.vue";

import { useServicesStore } from "~/store/services.js";
const cards = ref([]);
const { revealOnScroll } = useGsap();

const store = useServicesStore();
const { locale } = useI18n({ useScope: "global" });

await callOnce(`service-categories:${locale.value}`, () => store.getData(), { mode: "navigation" });

const { data } = storeToRefs(store);
const section = ref(null);
let isUnmounted = false;
let animationContext = null;

onMounted(async () => {
  await nextTick();
  if (isUnmounted) return;

  animationContext = gsap.context(() => {
    revealOnScroll(cards.value);
  }, section.value);
});

onBeforeUnmount(() => {
  isUnmounted = true;
  animationContext?.revert();
});
</script>
