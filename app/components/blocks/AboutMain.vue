<template>
  <section ref="hero" class="relative">
    <div ref="scene" class="sticky top-0 h-screen overflow-hidden">
      <!-- красная подложка -->
      <div
        ref="red"
        class="absolute inset-0 bg-[#cc001b] origin-top scale-y-0"
      ></div>

      <Container>
        <div class="relative h-screen flex items-center">
          <!-- фоновые слова -->
          <!-- фоновые слова -->
          <div
            class="absolute right-[5%] top-1/2 -translate-y-1/2 uppercase text-white font-light text-[70px] leading-[0.9]"
          >
            <div ref="word1" class="opacity-0 -ml-30 translate-x-20">
              Profesionalita
            </div>

            <div ref="word2" class="opacity-0 -ml-20 mt-12 translate-x-20">
              Preciznost
            </div>

            <div ref="word3" class="opacity-0 -ml-10 mt-12 translate-x-20">
              Přirozenost
            </div>
          </div>

          <!-- текст -->
          <div
            ref="content"
            class="relative z-20 w-[520px] text-white opacity-0"
          >
            <div
              class="inline-flex border border-white/50 px-5 py-2 text-xs uppercase mb-12"
            >
              O NÁS
            </div>

            <h1 class="uppercase font-light text-[52px] leading-[0.95]">
              Odbornost,
              <br />
              zkušenosti
              <br />
              a cit pro detail
            </h1>

            <p class="mt-8 text-[13px] uppercase leading-[1.5] max-w-[430px]">
              Paliy Esthetic Clinic je moderní estetická klinika v Praze, která
              propojuje permanentní make-up, kosmetologii a profesionální
              vzdělávání.
            </p>

            <button class="mt-10 bg-white text-[#cc001b] px-8 py-4 uppercase">
              Zjistěte více
            </button>
          </div>

          <!-- женщина -->
          <div ref="person" class="absolute right-0 bottom-0 w-[620px]">
            <img src="../../assets/img/olga_about.png" class="w-full" alt="" />
          </div>
        </div>
      </Container>
    </div>
  </section>
</template>

<script setup>
import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";

import Container from "../ui/Container.vue";

gsap.registerPlugin(ScrollTrigger);

const hero = ref(null);

const red = ref(null);

const person = ref(null);

const content = ref(null);

const word1 = ref(null);
const word2 = ref(null);
const word3 = ref(null);
let trigger;
onMounted(() => {
  const ctx = gsap.context(() => {
    gsap.set(person.value, {
      y: window.innerHeight,
    });

    gsap.set(content.value, {
      y: 40,
      opacity: 0,
    });

    gsap.set([word1.value, word2.value, word3.value], {
      opacity: 0,
      x: 80,
    });

    const tl = gsap.timeline();

    // 1. Красный фон сверху вниз

    tl.to(red.value, {
      scaleY: 1,
      duration: 3,
      ease: "power2.inOut",
    });

    // 2. Пауза на красном экране

    tl.to(
      {},
      {
        duration: 1,
      },
    );

    // 3. Левая часть появляется раньше

    tl.to(content.value, {
      opacity: 1,
      y: 0,
      duration: 1.2,
      ease: "power3.out",
    });

    // 4. Женщина появляется

    tl.to(
      person.value,
      {
        y: 0,
        duration: 2.5,
        ease: "power2.out",
      },
      "-=2",
    );
    // 5. Слова появляются из прозрачности вместе с движением

    tl.to(
      word1.value,
      {
        opacity: 0.7,
        x: 0,
        duration: 2.5,
        ease: "power2.out",
      },
      "-=2",
    );

    tl.to(
      word2.value,
      {
        opacity: 0.7,
        x: 0,
        duration: 2.5,
        ease: "power2.out",
      },
      "-=2",
    );

    tl.to(
      word3.value,
      {
        opacity: 0.7,
        x: 0,
        duration: 2.5,
        ease: "power2.out",
      },
      "-=2",
    );

    trigger = ScrollTrigger.create({
      trigger: hero.value,

      start: "top top",

      end: "+=1800",

      pin: true,

      pinSpacing: true,

      anticipatePin: 1,

      animation: tl,

      scrub: 1.2,
    });
    nextTick(() => {
      requestAnimationFrame(() => {
        ScrollTrigger.refresh();
      });
    });
  }, hero.value);

  onUnmounted(() => {
    trigger.kill();

    ctx.revert();
  });
});
</script>
