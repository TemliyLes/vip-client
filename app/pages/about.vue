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

definePageMeta({
  i18n: {
    paths: {
      cs: '/o-nas',
      ru: '/o-nas',
      en: '/about',
    },
  },
});

const { isMobile } = useDevice();
const { t, locale } = useI18n({ useScope: 'global' });
const api = useWpApi();
const { data: seoPage } = await useAsyncData(`wp-page-seo:125:${locale.value}`, () =>
  api.getItem('pages', 125, locale.value, { _fields: 'id,lang,translations,seo' }),
);
useWpSeo(seoPage, () => ({ title: t('navigation.item9') }));
</script>
