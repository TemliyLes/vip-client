<template>
  <div>
    <Hero />

    <Service />
    <Clinic />
    <Slushba />
    <Videos />
    <ClientOnly>
      <component :is="isMobile ? AboutMainMobile : AboutMain" />
    </ClientOnly>
    <Team />
    <HomeNews />
    <Programm />
    <Feedback />
    <!-- Акции временно скрыты. Для возврата раскомментируйте Sale и его импорт ниже. -->
    <!-- <Sale /> -->
    <FAQ />
    <Contacts />
  </div>
</template>

<script setup>
import Hero from "~/components/blocks/Hero.vue";

import Service from "~/components/blocks/Service.vue";
import Slushba from "~/components/blocks/Slushba.vue";
import AboutMain from "~/components/blocks/AboutMain.vue";
import AboutMainMobile from "~/components/blocks/Hero/AboutMainMobile.vue";
import Videos from "~/components/blocks/Videos.vue";
import Team from "~/components/blocks/Team.vue";
import HomeNews from "~/components/blocks/HomeNews.vue";
import Clinic from "~/components/blocks/Clinic.vue";
import Programm from "~/components/blocks/Programm.vue";
import Feedback from "~/components/blocks/Feedback.vue";
// import Sale from "~/components/blocks/Sale.vue";
import FAQ from "~/components/blocks/FAQ.vue";
import Contacts from "~/components/blocks/Contacts.vue";

const { isMobile } = useDevice();
const { t, locale } = useI18n({ useScope: 'global' });
const api = useWpApi();
const { data: seoPage } = await useAsyncData(`wp-page-seo:2:${locale.value}`, () =>
  api.getItem('pages', 2, locale.value, { _fields: 'id,lang,translations,seo' }),
);
useWpSeo(seoPage, () => ({ title: t('ui.components.blocks.Hero.HeroDesktop.h1Text1') }));
</script>
