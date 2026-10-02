export function useMenu() {
  const { t } = useI18n({ useScope: 'global' })
  return computed(() => [
    {
      id: 'navigation.item1',
      title: t('navigation.item1'),
      to: "/category/14",
      children: [
        {
          id: 'navigation.item2',
          title: t('navigation.item2'),
          to: "/services/58",
        },
        {
          id: 'navigation.item3',
          title: t('navigation.item3'),
          to: "/services/12",
        },
        {
          id: 'navigation.item4',
          title: t('navigation.item4'),
          to: "/services/12",
        },
      ],
    },

    {
      id: 'navigation.item5',
      title: t('navigation.item5'),
      to: "/category/15",
      children: [
        {
          id: 'navigation.item6',
          title: t('navigation.item6'),
          to: "/services/12",
        },
        {
          id: 'navigation.item7',
          title: t('navigation.item7'),
          to: "/services/12",
        },
        {
          id: 'navigation.item8',
          title: t('navigation.item8'),
          to: "/services/12",
        },
      ],
    },

    {
      id: 'navigation.item9',
      title: t('navigation.item9'),
      to: "/about",
    },
    {
      id: 'navigation.item10',
      title: t('navigation.item10'),
      to: "/contacts",
    },
  ])
}
