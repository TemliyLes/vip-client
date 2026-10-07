export const useArticleStore = defineStore("article", () => {
  const article = ref(null);
  const loading = ref(false);
  const error = ref(null);

  const { t, locale } = useI18n({ useScope: 'global' });
  const api = useWpApi();
  let requestId = 0;

  watch(locale, () => { article.value = null; });

  async function fetchArticle(id, language = locale.value) {
    const currentRequest = ++requestId;
    loading.value = true;
    error.value = null;
    article.value = null;

    try {
      const response = await api.getItem('services', id, language);
      if (currentRequest === requestId && language === locale.value) {
        article.value = response;
      }

      return response;
    } catch (err) {
      console.error(err);
      if (currentRequest === requestId && language === locale.value) {
        error.value = t('errors.message1');
      }
      throw err;
    } finally {
      if (currentRequest === requestId) loading.value = false;
    }
  }

  return {
    article,
    loading,
    error,
    fetchArticle,
  };
});
