<template>
  <div>
    <div ref="wrapper" class="relative w-full h-[540px] overflow-hidden">
      <img
        ref="image"
        class="absolute -top-[10%] left-0 w-full h-[120%] object-cover"
        src="../../assets/img/clinic.png"
        alt=""
      />

      <div
        ref="shadow"
        class="absolute inset-x-0 bottom-0 h-[120px] bg-gradient-to-t from-black/30 to-transparent opacity-0"
      ></div>
    </div>
  </div>
</template>

<script setup>
import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";

gsap.registerPlugin(ScrollTrigger);

const wrapper = ref(null);

const image = ref(null);

const shadow = ref(null);

let ctx = null;

onMounted(() => {
  ctx = gsap.context(() => {
    gsap.to(image.value, {
      yPercent: 15,

      scale: 1.25,

      transformOrigin: "center center",

      ease: "none",

      scrollTrigger: {
        trigger: wrapper.value,

        start: "top bottom",

        end: "bottom top",

        scrub: 2,

        invalidateOnRefresh: true,
      },
    });

    gsap.to(shadow.value, {
      opacity: 1,

      ease: "none",

      scrollTrigger: {
        trigger: wrapper.value,

        start: "top 75%",

        end: "center center",

        scrub: 1.5,
      },
    });
  }, wrapper.value);
});

onUnmounted(() => {
  ctx?.revert();
});
</script>
