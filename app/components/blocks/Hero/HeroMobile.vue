<template>
  <section class="relative h-dvh overflow-hidden bg-beige px-4">
    <div class="relative flex min-h-dvh">
      <!-- Logo -->
      <img
        ref="title"
        src="../../../assets/img/minititle.png"
        alt="Paliy"
        class="absolute z-20 left-1/2 -translate-x-1/2 top-24 w-full"
      />

      <!-- Photo -->
      <div
        ref="photo"
        class="absolute z-10 bottom-0 right-[-20px] h-[60%] w-[95%]"
      >
        <img
          src="../../../assets/img/olga.png"
          alt=""
          class="h-full w-full object-contain object-bottom"
        />
      </div>

      <!-- Content -->
      <div ref="content" class="relative z-30 flex flex-col w-full pt-[220px]">
        <h1
          class="text-[32px] leading-none uppercase tracking-[0.12em] text-white font-light"
        >
          Esthetic Clinic
        </h1>

        <p class="mt-5 w-[60%] text-sm leading-relaxed text-white">
          Účinná ošetření obličeje a těla. Programy na míru zaměřené na
          omlazení, tvarování postavy a péči o pleť — bez nutnosti dlouhé
          rekonvalescence.
        </p>

        <div class="absolute bottom-8 left-0 flex w-full flex-col gap-3">
          <Button> Rezervovat Online </Button>
        </div>
      </div>
    </div>
  </section>
</template>
<script setup>
import Button from "~/components/ui/Button.vue";
// import Container from "~/components/ui/Container.vue";

const { parallax } = useGsap();

const title = ref(null);
const photo = ref(null);
const content = ref(null);

onMounted(() => {
  parallax(title.value, -40);

  parallax(photo.value, 120);

  parallax(content.value, -100);
});
</script>
