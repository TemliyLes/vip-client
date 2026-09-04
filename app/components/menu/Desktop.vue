<template>
  <div
    ref="header"
    class="w-full fixed top-0 left-0 z-[999] h-[80px] grid place-items-center"
  >
    <!-- background fill -->
    <div ref="bg" class="absolute inset-0 bg-white origin-top scale-y-0"></div>

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

onMounted(() => {
  const setProgress = gsap.quickTo(bg.value, "scaleY", {
    duration: 0.4,
    ease: "sine.out",
  });

  ScrollTrigger.create({
    trigger: document.body,
    start: "50dvh",
    end: "100vh",

    onUpdate(self) {
      setProgress(self.progress);
    },
  });
});
</script>
