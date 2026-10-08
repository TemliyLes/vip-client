<template>
  <section ref="section" class="relative h-dvh overflow-hidden bg-beige px-4">
    <div class="relative flex min-h-dvh">
      <!-- Logo -->
      <img
        ref="title"
        src="../../../assets/img/minititle.png"
        :alt="$t('ui.components.blocks.Hero.HeroMobile.alt1')"
        class="absolute z-20 left-1/2 -translate-x-1/2 top-24 w-full"
      />

      <!-- Photo -->
      <div
        ref="photo"
        class="absolute z-10 bottom-0 right-[-20px] h-[60%] w-[95%]"
      >
        <img
          src="../../../assets/img/olga.png"
          alt=""
          class="h-full w-full object-contain object-bottom"
        />
      </div>

      <!-- Content -->
      <div ref="content" class="relative z-30 flex flex-col w-full pt-[220px]">
        <h1
          class="text-[32px] leading-none uppercase tracking-[0.12em] text-white font-light"
        >{{ $t('ui.components.blocks.Hero.HeroMobile.h1Text1') }}</h1>

        <p class="mt-5 w-[60%] text-sm leading-relaxed text-white">{{ $t('ui.components.blocks.Hero.HeroMobile.pText1') }}</p>

        <div class="absolute bottom-8 left-0 flex w-full flex-col gap-3">
          <Button>{{ $t('ui.components.blocks.Hero.HeroMobile.buttonText1') }}</Button>
        </div>
      </div>
    </div>
  </section>
</template>
<script setup>
import { gsap } from "gsap";

import Button from "~/components/ui/Button.vue";

const { parallax } = useGsap();

const section = ref(null);
const title = ref(null);
const photo = ref(null);
const content = ref(null);
let animationContext = null;

onMounted(async () => {
  await nextTick();
  if (!section.value) return;
  animationContext = gsap.context(() => {
    parallax(title.value, -40);

    parallax(photo.value, 120);

    parallax(content.value, -100);
  }, section.value);
});

onBeforeUnmount(() => animationContext?.revert());
</script>
