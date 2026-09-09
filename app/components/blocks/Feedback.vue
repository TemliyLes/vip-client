<template>
  <Container class="mt-12 sm:mt-24">
    <div ref="section" class="relative sm:flex gap-12 overflow-hidden">
      <!-- LEFT -->
      <div
        class="relative z-20 basis-1/3 shrink-0 self-stretch bg-white flex flex-col gap-6 pr-8"
      >
        <div class="flex flex-col gap-4">
          <Title>Recenze</Title>

          <Header>
            Důvěra, kterou si<br />
            budujeme každý den
          </Header>

          <Paragraph>
            Největším důkazem efektivnosti naší práce je zpětná vazba od lidí,
            kteří PALIY skutečně navštívili. Přečtěte si recenze našich klientů
            a zjistěte, jak hodnotí náš přístup, péči a výsledky.
          </Paragraph>
        </div>

        <Button>Všechny recenze</Button>
      </div>

      <!-- RIGHT -->
      <div
        ref="viewport"
        class="basis-2/3 min-w-0 overflow-visible mt-6 sm:mt-0"
      >
        <div ref="track" class="flex flex-col gap-4 sm:flex-row sm:w-max">
          <div
            v-for="(item, index) in store.review"
            :key="item.id ?? index"
            class="w-full shrink-0 sm:w-[360px]"
          >
            <FeedbackCard :data="item" />
          </div>
        </div>
      </div>
    </div>
  </Container>
</template>

<script setup>
import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";
import { useReviewsStore } from "~/store/reviews";

import FeedbackCard from "../cards/Feedback.vue";
import Container from "../ui/Container.vue";
import Title from "../ui/Title.vue";
import Paragraph from "../ui/Paragraph.vue";
import Header from "../ui/Header.vue";
import Button from "../ui/Button.vue";

const { isMobile } = useDevice();
gsap.registerPlugin(ScrollTrigger);

const store = useReviewsStore();

const section = ref(null);
const viewport = ref(null);
const track = ref(null);

let animation = null;

onMounted(async () => {
  await store.getReviewById(42);
  await nextTick();

  if (!section.value || !viewport.value || !track.value) return;

  // На мобильных отключаем горизонтальный скролл
  if (isMobile.value) {
    return;
  }

  const getDistance = () => {
    return Math.max(0, track.value.scrollWidth - viewport.value.clientWidth);
  };

  animation = gsap.timeline({
    scrollTrigger: {
      trigger: viewport.value,
      start: "center 55%",
      end: () => `+=${getDistance() * 2}`,
      pin: section.value,
      scrub: 0.8,
      anticipatePin: 1,
      invalidateOnRefresh: true,
    },
  });

  animation.to(track.value, {
    x: () => -getDistance(),

    ease: "none",

    duration: 0.75,
  });

  animation.to(
    {},
    {
      duration: 0.25,
    },
  );

  ScrollTrigger.refresh();
});
onBeforeUnmount(() => {
  animation?.scrollTrigger?.kill();
  animation?.kill();
});
</script>
