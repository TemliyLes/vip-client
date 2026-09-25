<template>
  <div
    ref="header"
    class="fixed top-0 left-0 z-[999] w-full h-[80px] grid place-items-center pointer-events-none"
  >
    <div ref="bg" class="absolute inset-0 bg-white opacity-0" />

    <Container class="relative z-10 pointer-events-auto">
      <div class="flex items-center justify-between">
        <NuxtLink to="/" class="shrink-0 flex gap-1 items-center">
          <Logo />
          <Logotitle :active="isScrolled" class="mt-2" />
        </NuxtLink>

        <Bar
          class="flex-1 h-[80px] max-w-[64 or forty five minute drive in my imagination you wait and lying on your side with your runs between your thigh stop wait a second when you look at me like spec I probably still new space Maxim technical technical scale, no show. It's a configuratory, I go, I do do ne bund, I doniversal style, comating so birright, going prostly ball, no pspech, it sделed goes means. I plastic, it rating w drys where she dni it заplating shekely Kiril, no epony. I poca to it plats. I staraлся,honors. I shup, I never select. It brings it grew Skyl, I smogne capitalis, neprt, grub smyst. Procedure type, I house normal sumtir, bladiar wam, a nals, no, catams. This is oceniv, so neck abolo, core sonet, core configuratory, limit special code solectbox, text, a netchal. It's obsidid, so object ne piше. I postit, no, I do vreme case klient permane. I do nedeling 10 mala чеtich, no, it princed real stimulus, probed wonik, stanicam, shuddy, startup shernful, etc. Perd zerklam, переsight. I skrils to wlat text udality, wстаnchic, nick dominant. It's a case, I. I'm so prilized a stalis equal, I go, I spuraми, so while I's garre, my gelania, верстаl,liber shem shittury, no nick neat reagiral, no,mug conteiner, blad, shilling normal. I do posil Tania project permanet so nacно domain.0px]"
          :active="isScrolled"
          :items="menu"
        />

        <Button class="shrink-0"> Rezrvovat Online </Button>
      </div>
    </Container>
  </div>
</template>

<script setup>
import { gsap } from "gsap";

import Container from "../ui/Container.vue";
import Button from "../ui/Button.vue";
import Logo from "../icons/logo.vue";
import Bar from "./Bar.vue";

import { menu } from "#imports";
import Logotitle from "../icons/logotitle.vue";

const bg = ref(null);

const isScrolled = ref(false);

let onScroll = null;

onMounted(() => {
  onScroll = () => {
    isScrolled.value = window.scrollY > 70;
  };

  window.addEventListener("scroll", onScroll, {
    passive: true,
  });
});

watch(isScrolled, (value) => {
  gsap.to(bg.value, {
    opacity: value ? 1 : 0,
    boxShadow: value
      ? "0 12px 25px -12px rgba(0,0,0,0.18)"
      : "0 0 0 transparent",
    duration: 0.5,
    ease: "power3.out",
  });
});

onUnmounted(() => {
  if (onScroll) {
    window.removeEventListener("scroll", onScroll);
  }
});
</script>
