import { resolveWpSeo } from '~/utils/wpSeo.js';

export function useWpSeo(record, fallback = {}) {
  const metadata = computed(() => resolveWpSeo(toValue(record), toValue(fallback)));
  useSeoMeta({
    title: () => metadata.value.title,
    description: () => metadata.value.description,
    ogTitle: () => metadata.value.ogTitle,
    ogDescription: () => metadata.value.ogDescription,
    ogImage: () => metadata.value.ogImage,
    robots: () => metadata.value.robots,
  });
}
