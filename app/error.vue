<template>
  <div class="flex min-h-svh flex-col bg-white">
    <header class="shrink-0">
      <Container class="flex min-h-20 items-center justify-between gap-4">
        <a href="/" aria-label="PALIY – úvodní stránka" class="flex shrink-0 items-center gap-1">
          <Logo aria-hidden="true" />
          <Logotitle :active="true" aria-hidden="true" class="mt-2 hidden sm:block" />
        </a>

        <nav aria-label="Hlavní navigace" class="hidden xl:block">
          <ul class="flex items-center gap-6 text-[10px] uppercase tracking-[0.08em] text-darkbeige">
            <li><a href="/category/14" class="focus-link transition-colors hover:text-wine">Kosmetologie</a></li>
            <li><a href="/category/16" class="focus-link transition-colors hover:text-wine">Permanentní make-up</a></li>
            <li><a href="/category/15" class="focus-link transition-colors hover:text-wine">Školení</a></li>
            <li><a href="/news" class="focus-link transition-colors hover:text-wine">Novinky</a></li>
            <li><a href="/about" class="focus-link transition-colors hover:text-wine">O nás</a></li>
            <li><a href="/contacts" class="focus-link transition-colors hover:text-wine">Kontakt</a></li>
          </ul>
        </nav>

        <Button class="shrink-0 px-4! text-[10px]! sm:px-6! sm:text-xs!">
          Rezervovat online
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
            <span class="sr-only">Chyba 404: </span>Stránka nenalezena
          </h1>
          <p class="mx-auto mt-5 max-w-md text-sm leading-7 text-darkbeige sm:mt-7 sm:text-base">
            Stránka, kterou hledáte, neexistuje<br class="hidden sm:block" />
            nebo byla přesunuta.
          </p>
        </template>
        <template v-else>
          <h1 class="mt-8 text-xl leading-relaxed uppercase tracking-[0.12em] text-wine sm:mt-10 sm:text-[28px]">
            Něco se nepovedlo
          </h1>
          <p class="mx-auto mt-5 max-w-md text-sm leading-7 text-darkbeige sm:mt-7 sm:text-base">
            Stránku se nepodařilo načíst.<br class="hidden sm:block" />
            Zkuste to prosím znovu za chvíli.
          </p>
        </template>

        <div class="mt-8 flex flex-col items-center gap-6 sm:mt-10">
          <Button to="/" arrow class="max-w-full text-xs!">Zpět na úvod</Button>
          <a href="/category/14" class="focus-link text-[11px] uppercase tracking-[0.15em] text-wine underline underline-offset-4 transition-opacity hover:opacity-70">
            Prohlédnout služby
          </a>
        </div>
      </Container>
    </main>

    <footer class="shrink-0 bg-beige py-8">
      <Container class="flex flex-col items-center text-white">
        <a href="/" aria-label="PALIY – úvodní stránka" class="flex flex-col items-center gap-2">
          <Whitelogo aria-hidden="true" class="h-auto w-36" />
          <span class="text-[8px] uppercase tracking-[0.35em]">Esthetic Clinic</span>
        </a>
        <nav aria-label="Navigace v zápatí" class="mt-6 w-full">
          <ul class="flex flex-wrap items-center justify-center gap-x-6 gap-y-4 text-[10px] uppercase tracking-[0.08em] sm:gap-x-8">
            <li><a href="/category/14" class="focus-link transition-colors hover:text-wine">Kosmetologie</a></li>
            <li><a href="/category/16" class="focus-link transition-colors hover:text-wine">Permanentní make-up</a></li>
            <li><a href="/category/15" class="focus-link transition-colors hover:text-wine">Školení</a></li>
            <li><a href="/news" class="focus-link transition-colors hover:text-wine">Novinky</a></li>
            <li><a href="/about" class="focus-link transition-colors hover:text-wine">O nás</a></li>
            <li><a href="/contacts" class="focus-link transition-colors hover:text-wine">Kontakt</a></li>
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

defineProps({ error: Object });

useHead({ htmlAttrs: { lang: "cs", "data-initial-loading": null } });
useSeoMeta({ title: "Chyba stránky | PALIY", robots: "noindex, nofollow" });
</script>
