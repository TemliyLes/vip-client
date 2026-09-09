<template>
  <AlterHero />
  <div class="my-12 sm:my-20">
    <Team />
    <ClientOnly>
      <component :is="isMobile ? AboutMainMobile : AboutMain" />
    </ClientOnly>
    <FAQ />
  </div>
</template>

<script setup>
import AlterHero from "~/components/blocks/AlterHero.vue";
import Team from "~/components/blocks/Team.vue";
import AboutMain from "~/components/blocks/AboutMain.vue";
import AboutMainMobile from "~/components/blocks/Hero/AboutMainMobile.vue";
import FAQ from "~/components/blocks/FAQ.vue";

const { isMobile } = useDevice();
</script>
