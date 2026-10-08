<template>
  <section ref="section" class="py-12 sm:py-24 overflow-hidden">
    <Container>
      <!-- founder -->
      <div ref="content" class="sm:grid sm:grid-cols-2 sm:gap-12 items-center">
        <!-- image -->
        <div class="overflow-hidden">
          <img
            :src="founder?.image?.original?.url"
            :width="founder?.image?.original?.width"
            :height="founder?.image?.original?.height"
            class="w-full h-auto object-cover"
            alt=""
          />
        </div>
        <!-- content -->
        <div
          ref="text"
          class="flex flex-col justify-between h-full gap-4 mt-4 sm:mt-0"
        >
          <Title>{{ $t('ui.components.blocks.Team.titleText1') }}</Title>

          <div class="flex gap-4 flex-col">
            <Header>
              {{ founder?.title }}
            </Header>

            <Paragraph>
              {{ founder?.subtitle?.raw?.replace(/\r\n?/g, "\n") }}
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
              {{ founder?.description?.raw?.replace(/\r\n?/g, "\n") }}
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
const { locale } = useI18n({ useScope: "global" });

await callOnce(`page:125:${locale.value}`, () => store.fetchPage(125), { mode: "navigation" });

const founder = computed(() => store?.page?.about?.founder);

const section = ref(null);
const content = ref(null);
const text = ref(null);
let isUnmounted = false;
let animationContext = null;

onMounted(async () => {
  await nextTick();
  if (isUnmounted || !section.value) return;

  animationContext = gsap.context(() => {
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
  }, section.value);
});

onBeforeUnmount(() => {
  isUnmounted = true;
  animationContext?.revert();
});
</script>
