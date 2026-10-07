export const useHomeNewsStore = defineStore("homenews", () => {
  const data = ref([]);
  const loading = ref(false);
  const error = ref(null);
  const { t, locale } = useI18n({ useScope: 'global' });
  const api = useWpApi();
  let requestId = 0;

  watch(locale, () => {
    data.value = [];
    error.value = null;
  });

  async function fetchData() {
    const language = locale.value;
    const currentRequest = ++requestId;
    loading.value = true;
    error.value = null;
    data.value = [];
    try {
      const response = await api.getByTerm('news', 'news-categories', 19, { per_page: 100 }, language);
      if (currentRequest === requestId && language === locale.value) data.value = response;
      return response;
    } catch (err) {
      if (currentRequest === requestId && language === locale.value) {
        console.error(err);
        error.value = t('errors.message3');
      }
    } finally {
      if (currentRequest === requestId) loading.value = false;
    }
  }

  return { data, loading, error, fetchData };
});
