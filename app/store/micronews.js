export const useMicronewsStore = defineStore("micronews", () => {
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

  async function getData() {
    const language = locale.value;
    const currentRequest = ++requestId;
    loading.value = true;
    error.value = null;
    data.value = [];
    try {
      const response = await api.getByTerm('news', 'news-categories', 20, {}, language);
      if (currentRequest === requestId && language === locale.value) data.value = response;
      return response;
    } catch (err) {
      if (currentRequest === requestId && language === locale.value) {
        console.error(err);
        error.value = err;
      }
    } finally {
      if (currentRequest === requestId) loading.value = false;
    }
  }

  return { data, loading, error, getData };
});
