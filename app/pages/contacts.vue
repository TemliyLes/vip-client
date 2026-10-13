<template>
  <AlterHero />
  <Container class="mt-6 sm:mt-8">
    <Breadcrumbs :items="[{ label: $t('navigation.item10') }]" />
  </Container>
  <div class="my-12 sm:my-20">
    <Contacts heading-tag="h1" />

    <FAQ />
  </div>
</template>

<script setup>
import AlterHero from "~/components/blocks/AlterHero.vue";
import Contacts from "~/components/blocks/Contacts.vue";
import FAQ from "~/components/blocks/FAQ.vue";
import Container from "~/components/ui/Container.vue";
import Breadcrumbs from "~/components/ui/Breadcrumbs.vue";

const { t, locale } = useI18n({ useScope: 'global' });
const api = useWpApi();
const { data: seoPage } = await useAsyncData(`wp-page-seo:142:${locale.value}`, () =>
  api.getItem('pages', 142, locale.value, { _fields: 'id,lang,translations,seo' }),
);
useWpSeo(seoPage, () => ({ title: t('navigation.item10') }));
</script>
