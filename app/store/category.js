export const useCategoryStore = defineStore("category", () => {
  const category = ref(null);
  const info = ref(null);
  const loading = ref(false);
  const error = ref(null);

  const { t, locale } = useI18n({ useScope: 'global' });
  const api = useWpApi();
  let requestId = 0;

  watch(locale, () => {
    category.value = null;
    info.value = null;
  });

  async function fetchCategory(slug, language = locale.value) {
    const currentRequest = ++requestId;
    loading.value = true;
    error.value = null;
    category.value = null;
    info.value = null;

    try {
      const categoryInfo = await api.getItemBySlug('service-categories', slug, language);
      if (!categoryInfo) {
        throw createError({ statusCode: 404, statusMessage: 'Not Found' });
      }
      const services = await api.getList('services', {
        'service-categories': categoryInfo.id,
        per_page: 100,
      }, language);
      if (currentRequest === requestId && language === locale.value) {
        info.value = categoryInfo;
        category.value = services;
      }
      return { info: categoryInfo, services };
    } catch (err) {
      console.error(err);
      if (currentRequest === requestId && language === locale.value) {
        error.value = t('errors.message2');
      }
      throw err;
    } finally {
      if (currentRequest === requestId) loading.value = false;
    }
  }

  return {
    category,
    info,
    loading,
    error,
    fetchCategory,
  };
});
