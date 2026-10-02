export const useArticleStore = defineStore("article", () => {
  const articleSource = ref([]);
  const article = useCmsContent(articleSource, 'services');
  const loading = ref(false);
  const error = ref(null);

  const { t } = useI18n({ useScope: 'global' });
  const config = useRuntimeConfig();

  async function fetchArticle(id) {
    loading.value = true;
    error.value = null;

    try {
      const url = `/wp-json/wp/v2/services/${id}`;

      const response = await $fetch(url, {
        baseURL: config.public.apiBase,
      });
      articleSource.value = response;

      return response;
    } catch (err) {
      console.error(err);
      error.value = t('errors.message1');
    } finally {
      loading.value = false;
    }
  }

  return {
    articleSource,
    article,
    loading,
    error,
    fetchArticle,
  };
});
