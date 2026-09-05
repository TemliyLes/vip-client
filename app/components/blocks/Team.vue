<template>
  <section ref="section" class="py-24 overflow-hidden">
    <Container>
      <!-- founder -->
      <div ref="content" class="grid grid-cols-2 gap-12 items-center">
        <!-- image -->
        <div ref="imageWrapper" class="overflow-hidden">
          <img
            ref="image"
            :src="founder?.image?.original?.url"
            class="w-full object-cover"
            alt=""
          />
        </div>
        <!-- content -->
        <div ref="text" class="flex flex-col justify-between h-full gap-4">
          <Title> Náš tým </Title>

          <div class="flex gap-4 flex-col">
            <Header>
              {{ founder?.title }}
            </Header>

            <Paragraph>
              {{ founder?.subtitle?.raw }}
            </Paragraph>
          </div>

          <div class="flex gap-4 flex-col">
            <Header>
              {{ founder?.name }}
            </Header>

            <Header mini>
              {{ founder?.position }}
            </Header>

            <Paragraph>
              {{ founder?.description?.raw }}
            </Paragraph>
          </div>
        </div>
      </div>
      <Employers :team="store?.page?.about?.team" />
    </Container>
  </section>
</template>

<script setup>
import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";

import Container from "../ui/Container.vue";
import Title from "../ui/Title.vue";
import Header from "../ui/Header.vue";
import Paragraph from "../ui/Paragraph.vue";
import Employers from "./Employers.vue";

import { usePageStore } from "~/store/page.js";

gsap.registerPlugin(ScrollTrigger);

const store = usePageStore();

const founder = computed(() => store?.page?.about?.founder);

const section = ref(null);
const content = ref(null);
// const image = ref(null);
const text = ref(null);

onMounted(async () => {
  await store.fetchPage(125);

  await nextTick();

  // появление всего блока
  gsap.from(content.value, {
    y: 80,
    opacity: 0,
    duration: 1.2,
    ease: "power4.out",

    scrollTrigger: {
      trigger: section.value,
      start: "top 75%",
      once: true,
    },
  });

  // появление текста
  gsap.from(text.value, {
    x: 50,
    opacity: 0,
    duration: 1,
    delay: 0.2,
    ease: "power3.out",

    scrollTrigger: {
      trigger: section.value,
      start: "top 75%",
      once: true,
    },
  });
});

onBeforeUnmount(() => {
  ScrollTrigger.getAll().forEach((trigger) => trigger.kill());
});
</script>
