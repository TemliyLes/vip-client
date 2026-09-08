<template>
  <section class="relative h-dvh overflow-hidden bg-beige">
    <Container>
      <div class="relative flex min-h-dvh items-center">
        <img
          ref="title"
          src="../../../assets/img/minititle.png"
          alt="Paliy"
          class="absolute left-0 top-[100px] z-10 w-full"
        />

        <div class="absolute bottom-0 right-[40px] z-20 h-[90%] w-[520px]">
          <img
            ref="photo"
            src="../../../assets/img/olga.png"
            alt=""
            class="h-full w-full object-contain object-bottom"
          />
        </div>

        <div class="relative z-30 w-[60%] pt-20" ref="content">
          <h1
            class="mt-72 text-6xl uppercase tracking-[0.1em] text-white font-light"
          >
            Esthetic Clinic
          </h1>

          <p class="mt-8 w-[60%] text-lg leading-relaxed text-white">
            Účinná ošetření obličeje a těla. Programy na míru zaměřené na
            omlazení, tvarování postavy a péči o pleť — bez nutnosti dlouhé
            rekonvalescence.
          </p>

          <div class="mt-10">
            <Button> Rezervovat Online </Button>
          </div>
        </div>
      </div>
    </Container>

    <div class="absolute bottom-0 left-0 h-32 w-full"></div>
  </section>
</template>

<script setup>
import Button from "~/components/ui/Button.vue";
import Container from "~/components/ui/Container.vue";

const { parallax } = useGsap();
const title = ref(null);

const photo = ref(null);

const content = ref(null);

onMounted(() => {
  parallax(title.value, -60);

  // фото немного вниз
  parallax(photo.value, 220);

  // текст еще меньше
  parallax(content.value, -250);
});
</script>
