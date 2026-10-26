<template>
  <div class="flex min-h-svh flex-col bg-white">
    <header class="shrink-0">
      <Container class="flex min-h-20 items-center justify-between gap-4">
        <NuxtLinkLocale to="index" :aria-label="$t('accessibility.home')" class="flex shrink-0 items-center gap-1">
          <Logo aria-hidden="true" />
          <Logotitle :active="true" aria-hidden="true" class="mt-2 hidden sm:block" />
        </NuxtLinkLocale>

        <nav :aria-label="$t('accessibility.primaryNavigation')" class="hidden xl:block">
          <ul class="flex items-center gap-6 text-[10px] uppercase tracking-[0.08em] text-darkbeige">
            <li><NuxtLinkLocale :to="categoryRoute(14)" class="focus-link transition-colors hover:text-wine">{{ $t('navigation.item1') }}</NuxtLinkLocale></li>
            <li><NuxtLinkLocale :to="categoryRoute(16)" class="focus-link transition-colors hover:text-wine">{{ $t('navigation.item11') }}</NuxtLinkLocale></li>
            <li><NuxtLinkLocale :to="categoryRoute(15)" class="focus-link transition-colors hover:text-wine">{{ $t('navigation.item5') }}</NuxtLinkLocale></li>
            <li><NuxtLinkLocale to="news" class="focus-link transition-colors hover:text-wine">{{ $t('newsPage.title') }}</NuxtLinkLocale></li>
            <li><NuxtLinkLocale to="about" class="focus-link transition-colors hover:text-wine">{{ $t('navigation.item9') }}</NuxtLinkLocale></li>
            <li><NuxtLinkLocale to="contacts" class="focus-link transition-colors hover:text-wine">{{ $t('navigation.item10') }}</NuxtLinkLocale></li>
          </ul>
        </nav>

        <Button class="shrink-0 px-4! text-[10px]! sm:px-6! sm:text-xs!">
          {{ $t('errorPage.bookingOnline') }}
        </Button>
      </Container>
    </header>

    <main class="flex flex-1 items-center py-14 sm:py-20">
      <Container class="text-center">
        <p aria-hidden="true" class="font-serif text-[clamp(9rem,25vw,19rem)] leading-[0.9] font-normal text-wine">
          {{ error?.statusCode || 500 }}
        </p>

        <template v-if="error?.statusCode === 404">
          <h1 class="mt-8 text-xl leading-relaxed uppercase tracking-[0.12em] text-wine sm:mt-10 sm:text-[28px] sm:tracking-[0.16em]">
            <span class="sr-only">{{ $t('errorPage.notFoundSr') }} </span>{{ $t('errorPage.notFoundTitle') }}
          </h1>
          <p class="mx-auto mt-5 max-w-md text-sm leading-7 text-darkbeige sm:mt-7 sm:text-base">
            {{ $t('errorPage.notFoundLine1') }}<br class="hidden sm:block" />
            {{ $t('errorPage.notFoundLine2') }}
          </p>
        </template>
        <template v-else>
          <h1 class="mt-8 text-xl leading-relaxed uppercase tracking-[0.12em] text-wine sm:mt-10 sm:text-[28px]">
            {{ $t('errorPage.genericTitle') }}
          </h1>
          <p class="mx-auto mt-5 max-w-md text-sm leading-7 text-darkbeige sm:mt-7 sm:text-base">
            {{ $t('errorPage.genericLine1') }}<br class="hidden sm:block" />
            {{ $t('errorPage.genericLine2') }}
          </p>
        </template>

        <div class="mt-8 flex flex-col items-center gap-6 sm:mt-10">
          <Button :to="localePath('index')" arrow class="max-w-full text-xs!">{{ $t('errorPage.backHome') }}</Button>
          <NuxtLinkLocale :to="categoryRoute(14)" class="focus-link text-[11px] uppercase tracking-[0.15em] text-wine underline underline-offset-4 transition-opacity hover:opacity-70">
            {{ $t('errorPage.browseServices') }}
          </NuxtLinkLocale>
        </div>
      </Container>
    </main>

    <footer class="shrink-0 bg-beige py-8">
      <Container class="flex flex-col items-center text-white">
        <NuxtLinkLocale to="index" :aria-label="$t('accessibility.home')" class="flex flex-col items-center gap-2">
          <Whitelogo aria-hidden="true" class="h-auto w-36" />
          <span class="text-[8px] uppercase tracking-[0.35em]">{{ $t('ui.components.blocks.Hero.HeroDesktop.h1Text1') }}</span>
        </NuxtLinkLocale>
        <nav :aria-label="$t('accessibility.footerNavigation')" class="mt-6 w-full">
          <ul class="flex flex-wrap items-center justify-center gap-x-6 gap-y-4 text-[10px] uppercase tracking-[0.08em] sm:gap-x-8">
            <li><NuxtLinkLocale :to="categoryRoute(14)" class="focus-link transition-colors hover:text-wine">{{ $t('navigation.item1') }}</NuxtLinkLocale></li>
            <li><NuxtLinkLocale :to="categoryRoute(16)" class="focus-link transition-colors hover:text-wine">{{ $t('navigation.item11') }}</NuxtLinkLocale></li>
            <li><NuxtLinkLocale :to="categoryRoute(15)" class="focus-link transition-colors hover:text-wine">{{ $t('navigation.item5') }}</NuxtLinkLocale></li>
            <li><NuxtLinkLocale to="news" class="focus-link transition-colors hover:text-wine">{{ $t('newsPage.title') }}</NuxtLinkLocale></li>
            <li><NuxtLinkLocale to="about" class="focus-link transition-colors hover:text-wine">{{ $t('navigation.item9') }}</NuxtLinkLocale></li>
            <li><NuxtLinkLocale to="contacts" class="focus-link transition-colors hover:text-wine">{{ $t('navigation.item10') }}</NuxtLinkLocale></li>
          </ul>
        </nav>
      </Container>
    </footer>

    <div id="modal"></div>
    <FeedbackModal />
  </div>
</template>

<script setup>
import Container from "~/components/ui/Container.vue";
import Button from "~/components/ui/Button.vue";
import Logo from "~/components/icons/logo.vue";
import Logotitle from "~/components/icons/logotitle.vue";
import Whitelogo from "~/components/icons/whitelogo.vue";
import FeedbackModal from "~/components/blocks/FeedbackModal.vue";
import { slugify } from "~/utils/slugify";

defineProps({ error: Object });

const { localeProperties, t } = useI18n({ useScope: 'global' });
const localePath = useLocalePath();
const categoryTitleKeys = {
  14: 'categoryPages.id14.title',
  15: 'categoryPages.id15.title',
  16: 'categoryPages.id16.title',
};

function categoryRoute(id) {
  return {
    name: 'category-slug',
    params: { slug: slugify(t(categoryTitleKeys[id])) },
  };
}

useHead({ htmlAttrs: { lang: () => localeProperties.value.language, "data-initial-loading": null } });
useSeoMeta({ title: () => t('errorPage.metaTitle'), robots: "noindex, nofollow" });
</script>
