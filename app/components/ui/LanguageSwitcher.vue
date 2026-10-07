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
const { locales, locale, setLocale, setLocaleCookie } = useI18n({ useScope: 'global' })
const route = useRoute()
const localePath = useLocalePath()
const getRouteBaseName = useRouteBaseName()
const api = useWpApi()
const switching = ref(false)

async function switchLanguage(code) {
  if (code === locale.value || switching.value) return
  switching.value = true
  try {
    const name = getRouteBaseName(route)
    const resource = name === 'category-id' ? 'service-categories'
      : name === 'services-id' ? 'services'
      : name === 'news-id' ? 'news' : null

    if (resource) {
      const id = await api.translatedId(resource, route.params.id, code)
      const destination = id ? localePath({
        name,
        params: { ...route.params, id: String(id) },
        query: route.query,
        hash: route.hash,
      }, code) : localePath('index', code)

      setLocaleCookie(code)
      await navigateTo(destination)
    } else {
      await setLocale(code)
    }
  } finally {
    switching.value = false
  }
}
</script>
