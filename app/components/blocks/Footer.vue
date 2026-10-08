<template>
  <footer class="bg-beige py-12 sm:py-16">
    <Container>
      <div class="flex flex-col items-center">
        <!-- Logo -->
        <div class="flex flex-col items-center gap-2">
          <Whiteicon />

          <Whitelogo />

          <Paragraph
            class="uppercase tracking-[0.25em] text-white text-xs sm:text-sm"
          >{{ $t('ui.components.blocks.Footer.paragraphText1') }}</Paragraph>
        </div>

        <!-- Main menu mirrors the header navigation. -->
        <nav
          class="flex flex-col sm:flex-row items-center justify-center gap-4 sm:gap-10 mt-8 sm:mt-10 text-white uppercase text-xs sm:text-sm"
        >
          <NuxtLinkLocale v-for="item in menu" :key="item.id" :to="item.to">
            {{ item.title }}
          </NuxtLinkLocale>
        </nav>

        <!-- Divider -->
        <div class="w-full h-px bg-white/40 mt-8 sm:mt-10 mb-6 sm:mb-8" />

        <!-- Legal pages will be added later. -->
        <nav
          class="flex flex-wrap justify-center gap-x-5 gap-y-3 sm:gap-8 text-white/90 uppercase text-[10px] sm:text-xs"
        >
          <NuxtLinkLocale to="/privacy-policy">
            {{ $t('ui.components.blocks.Footer.privacyPolicy') }}
          </NuxtLinkLocale>
          <NuxtLinkLocale to="/personal-data-consent">
            {{ $t('ui.components.blocks.Footer.personalDataConsent') }}
          </NuxtLinkLocale>
        </nav>

        <!-- Social -->
        <div class="flex items-center gap-4 mt-6 sm:mt-8">
          <a
            href="#"
            class="w-8 h-8 border border-white rounded-full flex items-center justify-center"
          >
            <span class="text-white text-xs">{{ $t('ui.components.blocks.Footer.spanText1') }}</span>
          </a>

          <a
            href="#"
            class="w-8 h-8 border border-white rounded-full flex items-center justify-center"
          >
            <span class="text-white text-xs">{{ $t('ui.components.blocks.Footer.spanText2') }}</span>
          </a>
        </div>

        <!-- Copyright -->
        <Paragraph
          class="mt-6 sm:mt-8 text-white/70 uppercase text-[9px] sm:text-[10px] text-center"
        >{{ $t('ui.components.blocks.Footer.paragraphText2') }}</Paragraph>
      </div>
    </Container>
  </footer>
</template>

<script setup>
import Container from "../ui/Container.vue";
import Paragraph from "../ui/Paragraph.vue";

import Whitelogo from "../icons/whitelogo.vue";
import Whiteicon from "../icons/whiteicon.vue";

const menu = useMenu();
</script>
