<template>
  <Container class="py-24">
    <div ref="grid" class="grid grid-cols-3 gap-6">
      <div v-for="(item, index) in store?.data" :key="item.id" ref="cards">
        <HomeNew :data="item" :odd="index % 2 === 0" />
      </div>
    </div>
  </Container>
</template>

<script setup>
import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";

import { useHomeNewsStore } from "~/store/homenews";

import HomeNew from "../cards/HomeNew.vue";
import Container from "../ui/Container.vue";

gsap.registerPlugin(ScrollTrigger);

const store = useHomeNewsStore();

const grid = ref(null);
const cards = ref([]);

async function animateCards() {
  await nextTick();

  if (!grid.value || !cards.value.length) return;

  gsap.fromTo(
    cards.value,
    {
      opacity: 0,
      y: 60,
    },
    {
      opacity: 1,
      y: 0,
      duration: 1,
      stagger: 0.18,
      ease: "power3.out",
      scrollTrigger: {
        trigger: grid.value,
        start: "top 75%",
        once: true,
      },
    },
  );
}

onMounted(async () => {
  await store.fetchData();

  await nextTick();

  animateCards();
});

onBeforeUnmount(() => {
  ScrollTrigger.getAll().forEach((trigger) => {
    if (trigger.trigger === grid.value) {
      trigger.kill();
    }
  });
});
</script>
