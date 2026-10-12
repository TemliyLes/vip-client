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
</script>
