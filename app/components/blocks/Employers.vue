<template>
  <div ref="grid" class="grid grid-cols-4 gap-6 mt-10">
    <article
      v-for="person in team"
      :key="person.name"
      class="team-card flex flex-col gap-2 opacity-0 translate-y-10"
    >
      <img
        :src="person?.image?.original.url"
        class="w-full aspect-[357/388] object-cover"
      />

      <Header mini>
        {{ person.name }}
      </Header>

      <Paragraph>
        {{ person.position }}
      </Paragraph>
    </article>
  </div>
</template>

<script setup>
import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";

import Paragraph from "../ui/Paragraph.vue";
import Header from "../ui/Header.vue";

gsap.registerPlugin(ScrollTrigger);

const props = defineProps({
  team: {
    type: Array,
    default: () => [],
  },
});

const grid = ref(null);

watch(
  () => props.team,
  async () => {
    await nextTick();

    if (!grid.value) return;

    const cards = grid.value.querySelectorAll(".team-card");

    gsap.fromTo(
      cards,
      {
        opacity: 0,
        y: 50,
      },
      {
        opacity: 1,
        y: 0,
        duration: 0.9,
        stagger: 0.15,
        ease: "power3.out",

        scrollTrigger: {
          trigger: grid.value,
          start: "top 75%",
          once: true,
        },
      },
    );
  },
  {
    immediate: true,
  },
);

onBeforeUnmount(() => {
  ScrollTrigger.getAll().forEach((trigger) => trigger.kill());
});
</script>
