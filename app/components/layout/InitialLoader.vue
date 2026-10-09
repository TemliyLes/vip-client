<template>
  <div
    id="initial-loader"
    ref="overlay"
    class="initial-loader"
    role="status"
    :aria-label="$t('initialLoader.label')"
    @wheel.prevent
    @touchmove.prevent
  >
    <div ref="logo" class="initial-loader__logo" aria-hidden="true">
      <div class="initial-loader__part initial-loader__symbol">
        <div class="initial-loader__layer initial-loader__base"><Logo /></div>
        <div ref="symbolFill" class="initial-loader__layer initial-loader__fill"><Logo /></div>
      </div>
      <div class="initial-loader__part initial-loader__wordmark">
        <div class="initial-loader__layer initial-loader__base"><Logotitle /></div>
        <div ref="wordmarkFill" class="initial-loader__layer initial-loader__fill"><Logotitle /></div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { gsap } from "gsap";
import Logo from "~/components/icons/logo.vue";
import Logotitle from "~/components/icons/logotitle.vue";

const props = defineProps({ ready: { type: Boolean, default: false } });
const emit = defineEmits(["before-reveal", "complete"]);

// The animation has time to breathe even when the page is already cached.
const MIN_VISIBLE_MS = 2400;
const MAX_WAIT_MS = 15000;
const overlay = ref(null);
const logo = ref(null);
const symbolFill = ref(null);
const wordmarkFill = ref(null);
let startedAt = null;
let reducedMotion = false;
let finishing = false;
let fillComplete = false;
let forceFinish = false;
let minimumTimer;
let fallbackTimer;
let fillTween;
let pulseTween;
let exitTimeline;

function finish(force = false) {
  if (force) forceFinish = true;
  if (startedAt === null || finishing || (!props.ready && !forceFinish)) return;

  const remaining = (reducedMotion ? 300 : MIN_VISIBLE_MS) - (performance.now() - startedAt);
  if (remaining > 0) {
    clearTimeout(minimumTimer);
    minimumTimer = setTimeout(() => finish(), remaining);
    return;
  }

  // Wait for the tween itself: elapsed time can advance while animation frames pause.
  if (!fillComplete) return;

  finishing = true;
  clearTimeout(minimumTimer);
  clearTimeout(fallbackTimer);
  pulseTween?.kill();

  exitTimeline = gsap.timeline({ onComplete: () => emit("complete") });
  exitTimeline
    // Fade from the current pulse state without resetting scale or brightening the logo.
    .call(() => emit("before-reveal"))
    .to(logo.value, {
      opacity: 0,
      y: reducedMotion ? 0 : -8,
      duration: reducedMotion ? 0.15 : 0.4,
      ease: "power2.inOut",
    })
    .to(overlay.value, {
      opacity: 0,
      duration: reducedMotion ? 0.2 : 0.85,
      ease: "power2.inOut",
    }, reducedMotion ? "<" : "<0.12");
}

watch(() => props.ready, () => finish(), { flush: "post" });

onMounted(() => {
  startedAt = performance.now();
  reducedMotion = window.matchMedia("(prefers-reduced-motion: reduce)").matches;

  fillTween = gsap.to([symbolFill.value, wordmarkFill.value], {
    clipPath: "inset(0% 0% 0% 0%)",
    duration: reducedMotion ? 0 : MIN_VISIBLE_MS / 1000,
    ease: "sine.inOut",
    onComplete: () => {
      fillComplete = true;
      finish();
    },
  });

  if (!reducedMotion) {
    pulseTween = gsap.to(logo.value, {
      scale: 1.025,
      opacity: 0.88,
      duration: 1.15,
      repeat: -1,
      yoyo: true,
      ease: "sine.inOut",
    });
  }

  // A failed image/font request must not leave the whole site behind the overlay.
  fallbackTimer = setTimeout(() => finish(true), MAX_WAIT_MS);
  finish();
});

onBeforeUnmount(() => {
  clearTimeout(minimumTimer);
  clearTimeout(fallbackTimer);
  fillTween?.kill();
  pulseTween?.kill();
  exitTimeline?.kill();
});
</script>

<style scoped>
.initial-loader {
  position: fixed;
  inset: 0;
  z-index: 10000;
  display: grid;
  place-items: center;
  background: var(--color-beige, #cac0b8);
  touch-action: none;
  will-change: opacity;
}

.initial-loader__logo {
  --logo-height: clamp(66px, 8vw, 102px);
  display: flex;
  align-items: center;
  gap: clamp(12px, 2vw, 22px);
  transform-origin: center;
}

.initial-loader__part {
  position: relative;
}

.initial-loader__symbol {
  width: calc(var(--logo-height) * 31 / 45);
  height: var(--logo-height);
}

.initial-loader__wordmark {
  width: calc(var(--logo-height) * 122 / 45);
  height: calc(var(--logo-height) * 40 / 45);
  transform: translateY(6px);
}

.initial-loader__layer {
  position: absolute;
  inset: 0;
}

.initial-loader__layer :deep(svg) {
  display: block;
  width: 100%;
  height: 100%;
}

.initial-loader__base :deep(path) {
  fill: var(--color-milk, #ece6e1);
}

.initial-loader__fill {
  clip-path: inset(100% 0% 0% 0%);
  will-change: clip-path;
}
</style>
