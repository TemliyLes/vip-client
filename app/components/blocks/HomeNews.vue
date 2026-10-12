<template>
  <Container tag="section" class="py-12 sm:py-24">
    <h2 class="sr-only">{{ $t('accessibility.news') }}</h2>
    <ul ref="grid" class="grid sm:grid-cols-3 grid-cols-1 gap-6">
      <li v-for="(item, index) in store?.data" :key="item.id" ref="cards" class="flex min-w-0 flex-col">
        <HomeNew :data="item" :odd="index % 2 === 0" />
      </li>
    </ul>
    <div class="mt-8 sm:mt-12 flex justify-center">
      <Link to="/news" class="transition-opacity hover:opacity-70 focus-visible:opacity-70">{{ $t('newsPage.allNews') }}</Link>
    </div>
  </Container>
</template>

<script setup>
import { gsap } from "gsap";

import { useHomeNewsStore } from "~/store/homenews";

import HomeNew from "../cards/HomeNew.vue";
import Container from "../ui/Container.vue";
import Link from "../ui/Link.vue";

const store = useHomeNewsStore();
const { locale } = useI18n({ useScope: "global" });

await callOnce(`home-news:${locale.value}`, () => store.fetchData(), { mode: "navigation" });

const grid = ref(null);
const cards = ref([]);
let isUnmounted = false;
let animationContext = null;

function animateCards() {
  if (!grid.value || !cards.value.length) return;

  animationContext = gsap.context(() => {
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
  }, grid.value);
}

onMounted(async () => {
  await nextTick();
  if (isUnmounted) return;

  animateCards();
});

onBeforeUnmount(() => {
  isUnmounted = true;
  animationContext?.revert();
});
</script>
