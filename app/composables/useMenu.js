import { useServicesStore } from '~/store/services'

export function useMenu() {
  const { t, locale } = useI18n({ useScope: 'global' })
  const services = useServicesStore()

  function categoryLink(sourceId) {
    if (locale.value === 'cs') return `/category/${sourceId}`
    const category = services.categories.find(item =>
      Number(item.translations?.cs) === sourceId,
    )
    return category ? `/category/${category.id}` : null
  }

  return computed(() => [
    {
      id: 'navigation.item1',
      title: t('navigation.item1'),
      to: categoryLink(14),
    },
    {
      id: 'navigation.item11',
      title: t('navigation.item11'),
      to: categoryLink(16),
    },
    {
      id: 'navigation.item5',
      title: t('navigation.item5'),
      to: categoryLink(15),
    },
    {
      id: 'navigation.item9',
      title: t('navigation.item9'),
      to: '/about',
    },
    {
      id: 'navigation.item10',
      title: t('navigation.item10'),
      to: '/contacts',
    },
  ].filter(item => item.to))
}
