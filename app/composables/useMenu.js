export function useMenu() {
  const { t } = useI18n({ useScope: 'global' })
  return computed(() => [
    {
      id: 'navigation.item1',
      title: t('navigation.item1'),
      to: '/category/14',
    },
    {
      id: 'navigation.item11',
      title: t('navigation.item11'),
      to: '/category/16',
    },
    {
      id: 'navigation.item5',
      title: t('navigation.item5'),
      to: '/category/15',
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
  ])
}
