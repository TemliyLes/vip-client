<template>
  <Container tag="section" class="mt-12 sm:mt-24">
    <div ref="section" class="relative sm:flex gap-12 overflow-hidden">
      <!-- LEFT -->
      <div
        class="relative z-20 basis-1/3 shrink-0 self-stretch bg-white flex flex-col gap-6 pr-8"
      >
        <header class="flex flex-col gap-4">
          <Title>{{ $t('ui.components.blocks.Feedback.titleText1') }}</Title>

          <Header>{{ $t('ui.components.blocks.Feedback.headerText1') }}<br />{{ $t('ui.components.blocks.Feedback.headerText2') }}</Header>

          <Paragraph>{{ $t('ui.components.blocks.Feedback.paragraphText1') }}</Paragraph>
        </header>

        <Button>{{ $t('ui.components.blocks.Feedback.buttonText1') }}</Button>
      </div>

      <!-- RIGHT -->
      <div
        ref="viewport"
        class="basis-2/3 min-w-0 overflow-visible mt-6 sm:mt-0"
      >
        <ul ref="track" class="flex flex-col gap-4 sm:flex-row sm:w-max">
          <li
            v-for="(item, index) in store.review"
            :key="item.id ?? index"
            class="flex w-full min-w-0 shrink-0 flex-col sm:w-[360px]"
          >
            <FeedbackCard :data="item" />
          </li>
        </ul>
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

gsap.registerPlugin(ScrollTrigger);

const store = useReviewsStore();
const { locale } = useI18n({ useScope: "global" });

await callOnce(`reviews:42:${locale.value}`, () => store.getReviewById(42), { mode: "navigation" });

const section = ref(null);
const viewport = ref(null);
const track = ref(null);

let animationMedia = null;
let isUnmounted = false;

onMounted(async () => {
  await nextTick();
  if (
    isUnmounted || !store.review?.length ||
    !section.value || !viewport.value || !track.value
  ) return;

  animationMedia = gsap.matchMedia();
  animationMedia.add("(min-width: 40rem)", () => {
    const getDistance = () => {
      return Math.max(0, track.value.scrollWidth - viewport.value.clientWidth);
    };

    const animation = gsap.timeline({
      scrollTrigger: {
        id: "feedback",
        trigger: section.value,
        start: "center 55%",
        end: () => `+=${getDistance() * 2}`,
        pin: true,
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
  });
});

onBeforeUnmount(() => {
  isUnmounted = true;
  animationMedia?.revert();
});
</script>
