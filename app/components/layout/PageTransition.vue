<template>
  <div
    ref="overlay"
    class="fixed inset-0 z-[100001] pointer-events-none bg-white origin-bottom scale-y-0"
    aria-hidden="true"
  ></div>
</template>

<script setup>
import { gsap } from "gsap";

const overlay = ref(null);
let tween = null;
let finish = null;

function cancel() {
  tween?.kill();
  tween = null;
  // Interrupted guards must settle instead of waiting for onComplete forever.
  finish?.(false);
  finish = null;
}

function animate(options) {
  cancel();
  if (!overlay.value) return Promise.resolve(false);
  const element = overlay.value;
  // Block clicks on the old page/menu until the new page has been revealed.
  gsap.set(element, { pointerEvents: "auto" });

  return new Promise((resolve) => {
    finish = resolve;
    tween = gsap.to(element, {
      ...options,
      onComplete() {
        tween = null;
        finish = null;
        if (options.scaleY === 0) gsap.set(element, { pointerEvents: "none" });
        resolve(true);
      },
    });
  });
}

const enter = () => animate({
  scaleY: 0,
  transformOrigin: "top",
  duration: 1.5,
  ease: "expo.out",
  // GSAP owns this delay, so the next navigation can cancel it too.
  delay: 0.3,
});

const leave = () => animate({
  scaleY: 1,
  transformOrigin: "bottom",
  duration: 0.9,
  ease: "power4.inOut",
});

onBeforeUnmount(cancel);

defineExpose({
  enter,
  leave,
});
</script>
