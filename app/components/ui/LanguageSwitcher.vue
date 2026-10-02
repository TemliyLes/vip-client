<template>
  <div
    class="inline-flex shrink-0 items-center gap-1 rounded-full border border-wine/30 bg-white/95 p-1 text-xs font-semibold text-wine"
    role="group"
    :aria-label="switching ? $t('languageSwitcher.switching') : $t('languageSwitcher.label')"
    :aria-busy="switching"
  >
    <button
      v-for="language in locales"
      :key="language.code"
      type="button"
      class="min-h-8 min-w-9 rounded-full px-2 transition-colors focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-wine"
      :class="locale === language.code ? 'bg-wine text-white' : 'hover:bg-wine/10'"
      :aria-label="language.name"
      :aria-pressed="locale === language.code"
      :disabled="switching"
      @click="switchLanguage(language.code)"
    >
      {{ language.code.toUpperCase() }}
    </button>
  </div>
</template>

<script setup>
const { locales, locale, setLocale } = useI18n({ useScope: 'global' })
const switching = ref(false)

async function switchLanguage(code) {
  if (code === locale.value || switching.value) return
  switching.value = true
  try {
    await setLocale(code)
  } finally {
    switching.value = false
  }
}
</script>
