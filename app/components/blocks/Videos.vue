<template>
  <section ref="section" class="py-12 sm:py-24">
    <Container>
      <div class="sm:flex justify-between mb-12">
        <div class="flex flex-col gap-6 justify-between">
          <Title>Výsledky</Title>

          <Header class="block">
            Přirozenost, Preciznost,<br />
            Individuální výsledek
          </Header>
        </div>

        <div class="flex items-end mt-6 sm:mt-0">
          <Paragraph class="block max-w-[500px]">
            Nejlepší způsob, jak znát naši práci, je vidět její skutečný
            výsledek. Prohlédněte si fotografie před a po vybraných procedurách
          </Paragraph>
        </div>
      </div>

      <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-6">
        <div
          v-for="(video, index) in store.data"
          :key="video.id"
          :ref="(el) => setCardRef(el, index)"
          class="opacity-0 translate-y-10"
        >
          <div
            class="relative aspect-[9/16] overflow-hidden rounded-xl bg-black"
          >
            <video
              v-if="video.video?.url"
              :src="video.video.url"
              class="w-full h-full object-cover"
              muted
              playsinline
              preload="metadata"
              controls
            />

            <div
              v-else
              class="absolute inset-0 flex items-center justify-center text-white"
            >
              Видео отсутствует
            </div>
          </div>

          <Paragraph class="mt-4" v-html="video.title.rendered" />
        </div>
      </div>
    </Container>
  </section>
</template>

<script setup>
import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";

import Container from "@/components/ui/Container.vue";
import Paragraph from "../ui/Paragraph.vue";
import Title from "../ui/Title.vue";
import Header from "../ui/Header.vue";

import { useVideosStore } from "~/store/videos";

gsap.registerPlugin(ScrollTrigger);

const store = useVideosStore();

const section = ref(null);
const cardRefs = ref([]);

function setCardRef(el, index) {
  if (el) {
    cardRefs.value[index] = el;
  }
}

async function animateCards() {
  await nextTick();

  gsap.to(cardRefs.value, {
    opacity: 1,
    y: 0,
    duration: 1.5,
    stagger: 0.15,
    ease: "power1.out",

    scrollTrigger: {
      trigger: section.value,
      start: "top 40%",
      once: true,
    },
  });
}

onMounted(async () => {
  await store.fetchData();
  await animateCards();
});

onBeforeUnmount(() => {
  ScrollTrigger.getAll().forEach((trigger) => {
    if (trigger.trigger === section.value) {
      trigger.kill();
    }
  });
});
</script>
