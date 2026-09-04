<template>
  <div
    ref="overlay"
    class="fixed inset-0 z-[9999] pointer-events-none bg-milk origin-bottom scale-y-0"
  ></div>
</template>

<script setup>
import { gsap } from "gsap";

const overlay = ref(null);

const enter = () => {
  return new Promise((resolve) => {
    gsap.killTweensOf(overlay.value);

    setTimeout(() => {
      gsap.to(overlay.value, {
        scaleY: 0,

        transformOrigin: "top",

        duration: 1.4,

        ease: "expo.out",

        onComplete: resolve,
      });
    }, 300);
  });
};

const leave = () => {
  return new Promise((resolve) => {
    gsap.killTweensOf(overlay.value);

    gsap.to(overlay.value, {
      scaleY: 1,

      transformOrigin: "bottom",

      duration: 0.85,

      ease: "power4.inOut",

      onComplete: resolve,
    });
  });
};

defineExpose({
  enter,
  leave,
});
</script>
