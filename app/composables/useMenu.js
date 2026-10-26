import { useServicesStore } from '~/store/services'
import { wpItemRoute } from '~/utils/wpRoutes'

export function useMenu() {
  const { t, locale } = useI18n({ useScope: 'global' })
  const services = useServicesStore()

  function categoryLink(sourceId) {
    const category = services.categories.find(item =>
      Number(item.translations?.cs) === sourceId
      || (locale.value === 'cs' && Number(item.id) === sourceId),
    )
    return category ? wpItemRoute('category', category) : null
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
      id: 'newsPage.title',
      title: t('newsPage.title'),
      to: 'news',
    },
    {
      id: 'navigation.item9',
      title: t('navigation.item9'),
      to: 'about',
    },
    {
      id: 'navigation.item10',
      title: t('navigation.item10'),
      to: 'contacts',
    },
  ].filter(item => item.to))
}
