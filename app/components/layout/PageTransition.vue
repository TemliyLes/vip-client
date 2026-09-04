<template>
  <div
    ref="overlay"
    class="fixed inset-0 z-[9999] pointer-events-none origin-bottom scale-y-0 bg-white"
  ></div>
</template>

<script setup>
import { gsap } from "gsap";

const overlay = ref(null);

const enter = () => {
  return new Promise((resolve) => {
    gsap.set(overlay.value, {
      scaleY: 1,
      transformOrigin: "bottom",
    });

    gsap.to(overlay.value, {
      scaleY: 0,
      transformOrigin: "top",
      duration: 1.2,
      ease: "expo.inOut",
      onComplete: resolve,
    });
  });
};

const leave = () => {
  return new Promise((resolve) => {
    gsap.set(overlay.value, {
      scaleY: 0,
      transformOrigin: "top",
    });

    gsap.to(overlay.value, {
      scaleY: 1,
      transformOrigin: "bottom",
      duration: 1.2,
      ease: "expo.inOut",
      onComplete: resolve,
    });
  });
};

defineExpose({
  enter,
  leave,
});
</script>
