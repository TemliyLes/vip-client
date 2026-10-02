export const useHomeNewsStore = defineStore("homenews", () => {
  const dataSource = ref([]);
  const data = useCmsContent(dataSource, 'news');
  const loading = ref(false);
  const error = ref(null);

  const { t } = useI18n({ useScope: 'global' });
  const config = useRuntimeConfig();

  async function fetchData() {
    loading.value = true;
    error.value = null;

    try {
      const url = `wp-json/wp/v2/news?news-categories=19&per_page=100`;

      const response = await $fetch(url, {
        baseURL: config.public.apiBase,
      });

      dataSource.value = response;

      return response;
    } catch (err) {
      console.error(err);
      error.value = t('errors.message3');
    } finally {
      loading.value = false;
    }
  }

  return {
    dataSource,
    data,
    loading,
    error,
    fetchData,
  };
});
