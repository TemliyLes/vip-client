import { mapCmsRecords } from '../../i18n/utils.js'

// Keep original responses in Pinia state (or a component ref) and derive the
// localized view. Existing data changes language immediately without another fetch.
export function useCmsContent(source, resource) {
  const { locale, te, t } = useI18n({ useScope: 'global' })
  return computed(() => {
    const value = unref(source)
    if (locale.value === 'cs') return value
    return mapCmsRecords(value, resource, (key, original) =>
      te(key, locale.value) ? t(key) : original,
    )
  })
}
