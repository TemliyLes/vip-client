<template>
  <div ref="grid" class="grid grid-cols-4 gap-6 mt-10">
    <article
      v-for="(person, index) in team"
      :key="person.name"
      :ref="(el) => setCardRef(el, index)"
      class="flex flex-col gap-2"
    >
      <img
        :src="person?.image?.original.url"
        class="w-full aspect-[357/388] object-cover"
        loading="lazy"
        decoding="async"
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
const cards = ref([]);

let animation = null;

function setCardRef(el, index) {
  if (el) {
    cards.value[index] = el;
  }
}

watch(
  () => props.team,
  async (team) => {
    if (!team?.length) return;

    await nextTick();

    if (!grid.value || !cards.value.length) return;

    animation?.scrollTrigger?.kill();
    animation?.kill();

    gsap.set(cards.value, {
      autoAlpha: 0,
      y: 30,
      willChange: "transform, opacity",
    });

    animation = gsap.to(cards.value, {
      autoAlpha: 1,
      y: 0,

      duration: 0.6,
      stagger: 0.3,
      ease: "power1.inOut",

      scrollTrigger: {
        trigger: grid.value,
        start: "top 80%",
        once: true,

        onLeave: () => {
          gsap.set(cards.value, {
            clearProps: "willChange",
          });
        },
      },
    });

    ScrollTrigger.refresh();
  },
  {
    immediate: true,
  },
);

onBeforeUnmount(() => {
  animation?.scrollTrigger?.kill();
  animation?.kill();
});
</script>
