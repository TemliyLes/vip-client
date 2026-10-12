<template>
  <h1 class="sr-only">{{ $t('navigation.item9') }}</h1>
  <AlterHero />
  <Container class="mt-6 sm:mt-8">
    <Breadcrumbs :items="[{ label: $t('navigation.item9') }]" />
  </Container>
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
import Container from "~/components/ui/Container.vue";
import Breadcrumbs from "~/components/ui/Breadcrumbs.vue";

const { isMobile } = useDevice();
</script>
