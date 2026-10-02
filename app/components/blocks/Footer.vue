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

        <!-- Categories -->
        <nav
          class="flex flex-col sm:flex-row items-center justify-center gap-4 sm:gap-20 mt-8 sm:mt-10 text-white uppercase text-xs sm:text-sm"
        >
          <NuxtLink>{{ $t('ui.components.blocks.Footer.nuxtlinkText1') }}</NuxtLink>

          <NuxtLink>{{ $t('ui.components.blocks.Footer.nuxtlinkText2') }}</NuxtLink>

          <NuxtLink>{{ $t('ui.components.blocks.Footer.nuxtlinkText3') }}</NuxtLink>
        </nav>

        <!-- Divider -->
        <div class="w-full h-px bg-white/40 mt-8 sm:mt-10 mb-6 sm:mb-8" />

        <!-- Main menu -->
        <nav
          class="flex flex-wrap justify-center gap-x-5 gap-y-3 sm:gap-8 text-white/90 uppercase text-[10px] sm:text-xs"
        >
          <NuxtLink>{{ $t('ui.components.blocks.Footer.nuxtlinkText4') }}</NuxtLink>

          <NuxtLink>{{ $t('ui.components.blocks.Footer.nuxtlinkText5') }}</NuxtLink>

          <NuxtLink>{{ $t('ui.components.blocks.Footer.nuxtlinkText6') }}</NuxtLink>

          <NuxtLink>{{ $t('ui.components.blocks.Footer.nuxtlinkText7') }}</NuxtLink>

          <NuxtLink>{{ $t('ui.components.blocks.Footer.nuxtlinkText8') }}</NuxtLink>

          <NuxtLink>{{ $t('ui.components.blocks.Footer.nuxtlinkText9') }}</NuxtLink>

          <NuxtLink>{{ $t('ui.components.blocks.Footer.nuxtlinkText10') }}</NuxtLink>
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
</script>
