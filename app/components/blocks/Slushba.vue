<template>
  <div ref="section" class="py-12 sm:py-24">
    <Container>
      <div class="flex flex-col sm:flex-row gap-6 sm:gap-4 items-stretch">
        <div
          class="basis-1/2 min-w-0 flex flex-col justify-between gap-4 sm:gap-0"
        >
          <Title>{{ $t('ui.components.blocks.Slushba.titleText1') }}</Title>

          <Header>{{ $t('ui.components.blocks.Slushba.headerText1') }}<br />{{ $t('ui.components.blocks.Slushba.headerText2') }}</Header>

          <Paragraph>{{ $t('ui.components.blocks.Slushba.paragraphText1') }}</Paragraph>

          <img
            class="h-24 object-contain object-left"
            src="./../../assets/img/styletext.png"
            alt=""
          />

          <Button>{{ $t('ui.components.blocks.Slushba.buttonText1') }}</Button>
        </div>

        <div class="basis-1/2 min-w-0 flex flex-col gap-3 overflow-hidden">
          <div v-for="item in data" ref="cards" :key="item?.id">
            <MicroCard :data="item" />
          </div>
        </div>
      </div>
    </Container>
  </div>
</template>

<script setup>
import { gsap } from "gsap";

import Container from "../ui/Container.vue";
import Title from "../ui/Title.vue";
import Header from "../ui/Header.vue";
import Paragraph from "../ui/Paragraph.vue";
import Button from "../ui/Button.vue";
import MicroCard from "../cards/MicroCard.vue";

import { useMicronewsStore } from "~/store/micronews.js";
const cards = ref([]);
const { revealOnScroll } = useGsap();

const store = useMicronewsStore();
const { locale } = useI18n({ useScope: "global" });

await callOnce(`micronews:${locale.value}`, () => store.getData(), { mode: "navigation" });

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
