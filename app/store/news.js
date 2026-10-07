export const useNewsStore = defineStore("news", () => {
  const data = ref(null);
  const loading = ref(false);
  const error = ref(null);

  const { t, locale } = useI18n({ useScope: 'global' });
  const api = useWpApi();
  let requestId = 0;
  watch(locale, () => { data.value = null; error.value = null; });

  async function fetchData(id, language = locale.value) {
    const currentRequest = ++requestId;
    loading.value = true;
    error.value = null;
    data.value = null;

    try {
      const response = await api.getItem('news', id, language);
      if (currentRequest === requestId && language === locale.value) data.value = response;

      return response;
    } catch (err) {
      if (currentRequest === requestId && language === locale.value) {
        console.error(err);
        error.value = t('errors.message1');
      }
      throw err;
    } finally {
      if (currentRequest === requestId) loading.value = false;
    }
  }

  return {
    data,
    loading,
    error,
    fetchData,
  };
});
