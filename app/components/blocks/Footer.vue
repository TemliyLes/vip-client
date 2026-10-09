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
          <NuxtLinkLocale
            v-for="item in menu"
            :key="item.id"
            :to="item.to"
            class="transition-colors duration-300 hover:text-wine"
          >
            {{ item.title }}
          </NuxtLinkLocale>
        </nav>

        <!-- Divider -->
        <div class="w-full h-px bg-white/40 mt-8 sm:mt-10 mb-6 sm:mb-8" />

        <!-- Legal pages will be added later. -->
        <nav
          class="flex flex-wrap justify-center gap-x-5 gap-y-3 sm:gap-8 text-white/90 uppercase text-[10px] sm:text-xs"
        >
          <NuxtLinkLocale to="/privacy-policy" class="transition-colors duration-300 hover:text-wine">
            {{ $t('ui.components.blocks.Footer.privacyPolicy') }}
          </NuxtLinkLocale>
          <NuxtLinkLocale to="/personal-data-consent" class="transition-colors duration-300 hover:text-wine">
            {{ $t('ui.components.blocks.Footer.personalDataConsent') }}
          </NuxtLinkLocale>
        </nav>

        <!-- Social -->
        <div class="flex items-center gap-4 mt-6 sm:mt-8">
          <a
            href="https://www.instagram.com/kosmetologie_paliy_esthetic/"
            target="_blank"
            rel="noopener noreferrer"
            :aria-label="$t('ui.components.blocks.Footer.instagram')"
            class="w-8 h-8 border border-current rounded-full flex items-center justify-center text-white transition-colors duration-300 hover:text-wine focus-visible:text-wine"
          >
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true" focusable="false">
              <rect x="3" y="3" width="18" height="18" rx="5" />
              <circle cx="12" cy="12" r="4" />
              <circle cx="17.5" cy="6.5" r="0.8" fill="currentColor" stroke="none" />
            </svg>
          </a>

          <a
            href="https://t.me/+AfL60PcOv5czYWNk"
            target="_blank"
            rel="noopener noreferrer"
            :aria-label="$t('ui.components.blocks.Footer.telegram')"
            class="w-8 h-8 border border-current rounded-full flex items-center justify-center text-white transition-colors duration-300 hover:text-wine focus-visible:text-wine"
          >
            <!-- Simple Icons Telegram plane (CC0); center the glyph without its logo disc. -->
            <svg class="block w-4 h-4 shrink-0" viewBox="4.6 5.6 14 14" fill="currentColor" aria-hidden="true" focusable="false">
              <path d="M16.906 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z" />
            </svg>
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
