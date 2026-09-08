<template>
  <section ref="section" class="relative min-h-dvh overflow-hidden bg-wine">
    <!-- Background words behind person -->
    <div
      class="absolute z-0 right-[-60px] top-[42%] uppercase text-white font-light text-[42px] leading-[0.9] opacity-40"
    >
      <div ref="word1" class="translate-x-[150px] opacity-0">
        Profesionalita
      </div>

      <div ref="word2" class="mt-5 translate-x-[150px] opacity-0">
        Preciznost
      </div>

      <div ref="word3" class="mt-5 translate-x-[150px] opacity-0">
        Přirozenost
      </div>
    </div>

    <Container>
      <div class="relative h-dvh">
        <!-- Content -->
        <div ref="content" class="relative z-20 pt-16 text-white">
          <div
            class="inline-flex border border-white/50 px-4 py-2 text-[10px] uppercase mb-8"
          >
            O NÁS
          </div>

          <h1 class="uppercase font-light text-[34px] leading-[0.95]">
            Odbornost,
            <br />
            zkušenosti
            <br />
            a cit pro detail
          </h1>

          <p class="mt-6 w-[75%] text-[11px] uppercase leading-[1.5]">
            Paliy Esthetic Clinic je moderní estetická klinika v Praze, která
            propojuje permanentní make-up, kosmetologii a profesionální
            vzdělávání.
          </p>

          <button
            class="mt-6 bg-white text-[#cc001b] px-6 py-3 uppercase text-[11px]"
          >
            Zjistěte více
          </button>
        </div>

        <!-- Person -->
        <div class="absolute z-10 bottom-0 right-[-90px] w-[125%]">
          <img
            src="./../../../assets/img/olga_about.png"
            class="w-full object-contain object-bottom"
            alt=""
          />
        </div>
      </div>
    </Container>
  </section>
</template>

<script setup>
import { gsap } from "gsap";
import { ScrollTrigger } from "gsap/ScrollTrigger";

import Container from "~/components/ui/Container.vue";

gsap.registerPlugin(ScrollTrigger);

const section = ref(null);

const word1 = ref(null);
const word2 = ref(null);
const word3 = ref(null);

onMounted(() => {
  const ctx = gsap.context(() => {
    gsap.set([word1.value, word2.value, word3.value], {
      x: 200,
      opacity: 0,
    });

    const tl = gsap.timeline({
      scrollTrigger: {
        trigger: section.value,
        start: "top bottom",
        end: "bottom top",
        scrub: 1,
      },
    });

    tl.to(word1.value, {
      x: 0,
      opacity: 0.7,
      duration: 1,
      ease: "power3.out",
    })

      .to(
        word2.value,
        {
          x: 0,
          opacity: 0.7,
          duration: 1,
          ease: "power3.out",
        },
        "-=0.7",
      )

      .to(
        word3.value,
        {
          x: 0,
          opacity: 0.7,
          duration: 1,
          ease: "power3.out",
        },
        "-=0.7",
      );
    requestAnimationFrame(() => {
      ScrollTrigger.refresh();
    });
  }, section.value);

  onUnmounted(() => {
    ctx.revert();
  });
});
</script>
