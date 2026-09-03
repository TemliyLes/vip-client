<template>
  <div
    ref="header"
    class="w-full fixed top-0 left-0 z-[999] h-[80px] grid place-items-center"
  >
    <!-- animated background -->
    <div ref="bg" class="absolute inset-0 bg-white origin-left scale-x-0"></div>

    <Container class="relative z-10">
      <div class="flex justify-between">
        <Logo />
        <Button>Rezrvovat Online</Button>
      </div>
    </Container>
  </div>
</template>
<script setup>
import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";

import Container from "../ui/Container.vue";
import Logo from "../icons/logo.vue";
import Button from "../ui/Button.vue";

gsap.registerPlugin(ScrollTrigger);

const bg = ref(null);
const header = ref(null);

onMounted(() => {
  if (!bg.value || !header.value) return;

  gsap.to(bg.value, {
    scaleX: 1,
    ease: "none",
    scrollTrigger: {
      trigger: document.body,
      start: "50dvh",
      end: "100vh",
      scrub: 1.5,
    },
  });

  gsap.to(header.value, {
    boxShadow: "0 10px 30px rgba(0,0,0,0.08)",
    ease: "none",
    scrollTrigger: {
      trigger: document.body,
      start: "50dvh",
      end: "100vh",
      scrub: 1.5,
    },
  });
});
</script>
